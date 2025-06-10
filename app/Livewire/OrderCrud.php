<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;

class OrderCrud extends Component
{
    public $orders;     // Colección de pedidos cargados
    public $totalreturn = [];   // Array para llevar la cuenta de totales devueltos por pedido

    public $message = null;     // Mensaje que se mostrará al usuario
    public $messageType = 'success';    // Tipo de mensaje (success, warning, error)
    public $showMessage = false;    // Controla si se muestra el mensaje o no

    public $statusFilter = '';    // Filtro para el estado del pedido
    public $userName = '';   // Filtro para buscar pedidos por nombre de usuario
    public $startDate = '';  // Fecha inicial para filtrar pedidos por rango de fechas
    public $endDate = '';   // Fecha final para filtrar pedidos por rango de fechas

    /**
     * Método que se ejecuta al iniciar el componente.
     * Carga los pedidos y muestra mensaje si no hay ninguno.
     */
    public function mount()
    {
        $this->loadOrders();

        if ($this->orders->isEmpty()) {
            $this->setMessage('No hay ningún Pedido', 'warning');
        }
    }

    /**
     * Carga todos los pedidos con relaciones necesarias: usuario, productos y tallas.
     * Esto evita consultas N+1 y trae todo lo necesario para mostrar la información.
     */
    public function loadOrders()
    {
        $this->orders = Order::with(['user', 'items.product', 'items.size'])->get();
    }

    /**
     * Aplica filtros a los pedidos según estado, usuario y rango de fechas.
     * Se usa una consulta dinámica que se va agregando condiciones si los filtros están definidos.
     *
     * - whereHas() permite filtrar pedidos por datos relacionados (nombre de usuario).
     * - whereBetween() filtra pedidos por fecha entre dos valores.
     * - Si no hay resultados, muestra mensaje flash en sesión.
     */
    public function filter()
    {
        $query = Order::with(['user', 'items.product', 'items.size']);

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->userName)) {
            $query->whereHas('user', function ($q) {
                // Busca usuarios cuyo nombre contenga el texto introducido (búsqueda parcial)
                $q->where('name', 'like', '%' . $this->userName . '%');
            });
        }

        if (!empty($this->startDate) && !empty($this->endDate)) {
            // Filtro por rango de fechas creado_at, incluyendo ambos extremos
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        // Ejecuta la consulta con todos los filtros aplicados
        $this->orders = $query->get();

        // Si no se encontraron pedidos con los filtros, muestra un mensaje de error temporal
        if ($this->orders->isEmpty()) {
            session()->flash('error', 'No se encontraron pedidos con los filtros aplicados');
        }
    }

    /**
     * Restablece los filtros a sus valores vacíos y recarga todos los pedidos sin filtrar.
     */
    public function resetFilters()
    {
        $this->statusFilter = '';
        $this->userName = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->loadOrders();
    }

    /**
     * Actualiza el estado de un pedido específico.
     * Busca el pedido por su ID y si existe, actualiza su estado y lo guarda.
     *
     * @param int $orderId ID del pedido
     * @param string $status Nuevo estado a asignar
     */
    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }

    /**
     * Elimina un ítem (producto) de un pedido.
     *
     * Si el pedido está en estado 'pagado' o 'reembolsado', se incrementa el stock correspondiente
     * para la combinación producto-talla que se eliminó, devolviendo así el inventario.
     *
     * También acumula el total a devolver por ese ítem para mostrarlo o manejarlo después.
     * Finalmente actualiza el total del pedido sumando los precios por cantidades de los ítems restantes.
     *
     * Si después de eliminar el ítem el pedido queda sin productos y sin devolución pendiente,
     * se elimina el pedido completo y se muestra un mensaje.
     *
     * Luego recarga los pedidos para refrescar la vista.
     *
     * @param int $itemId ID del ítem de pedido
     */
    public function removeItem($itemId)
    {
        $item = OrderItem::find($itemId);

        if ($item) {
            $order = $item->order;

            // Si el pedido está pagado o reembolsado, devuelve el stock al inventario
            if ($order->status === 'pagado' || $order->status === 'reembolsado') {
                \DB::table('product_size')
                    ->where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->increment('stock', $item->quantity); // Suma la cantidad devuelta al stock


                // Inicializa el total de devolución para ese pedido si no existe
                if (!isset($this->totalreturn[$order->id])) {
                    $this->totalreturn[$order->id] = 0;
                }

                // Acumula el importe que se debe devolver para ese pedido
                $this->totalreturn[$order->id] += $item->price * $item->quantity;
            }

            // Elimina el ítem del pedido
            $item->delete();

            // Recalcula y actualiza el total del pedido basado en los ítems restantes
            $order->total = $order->items()->sum(\DB::raw('price * quantity'));
            $order->save();

            // Si no quedan ítems en el pedido y no hay devolución pendiente, elimina el pedido
            if ($order->items()->count() === 0 && (!isset($this->totalreturn[$order->id]) || $this->totalreturn[$order->id] == 0)) {
                $order->delete();
                $this->setMessage('Pedido #' . $order->id . ' eliminado porque no tiene productos.', 'warning');
            }
        }

        // Refresca la lista de pedidos para reflejar los cambios
        $this->loadOrders();
    }

    /**
     * Cambia el estado del pedido a 'reembolsado'.
     * Si el pedido no tiene productos, lo elimina.
     * Muestra un mensaje según el resultado.
     * Refresca la vista recargando el componente.
     *
     * @param int $orderId ID del pedido
     */
    public function returned($orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'reembolsado';
            $order->save();

            // Si no quedan productos, elimina el pedido
            if ($order->items()->count() === 0) {
                $order->delete();
                $this->setMessage('Pedido #' . $order->id . ' eliminado porque no tiene productos.', 'warning');
            } else {
                // Si aún tiene productos, solo notifica que se procesó la devolución
                $this->setMessage('Se ha procesado la devolución del dinero del Pedido #' . $order->id . '.', 'success');
            }
        }

        // Vuelve a cargar el componente para actualizar la vista
        $this->mount();
    }

    /**
     * Configura el mensaje para mostrar en la vista, con el texto y tipo (color).
     *
     * @param string $message Texto del mensaje
     * @param string $messageType Tipo de mensaje ('success', 'warning', 'error')
     */
    public function setMessage($message, $messageType = 'success')
    {
        $this->message = $message;
        $this->messageType = $messageType;
        $this->showMessage = true;
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.order-crud');
    }
}
