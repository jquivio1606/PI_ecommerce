<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;


class OrderCrud extends Component
{
    public $orders;
    public $totalreturn = []; // Arreglo para almacenar los totales a devolver por pedido
    
    public $message = null;
    public $messageType = 'success'; // 'success', 'error' o 'warning'
    public $showMessage = false;
    
    public $statusFilter = '';
    public $userName = '';
    public $startDate = '';
    public $endDate = '';
    public $filters = false;

    public function mount()
    {
        // Cargamos las órdenes con la relación de usuario, producto y tamaño
        $this->orders = Order::with(['user', 'items.product', 'items.size'])->get();

        // Comprobamos si no hay órdenes y mostramos un mensaje si es el caso
        if ($this->orders->isEmpty()) {
            $this->setMessage('No hay ningún Pedido', 'warning');
        }
    }


    public function filter()
    {
        // Inicializamos la consulta de las órdenes
        $query = Order::with(['user', 'items.product', 'items.size']);

        // Filtro por estado
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
            $this->filters = true;
        }

        // Filtro por nombre de usuario
        if (!empty($this->userName)) {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->userName . '%');
            });
            $this->filters = true;
        }

        // Filtro por fechas
        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            $this->filters = true;
        }

        // Actualizamos la variable de órdenes con los resultados filtrados
        $this->orders = $query->get();

        // Si no hay resultados
        if ($this->orders->isEmpty()) {
            session()->flash('error', 'No se encontraron pedidos con los filtros aplicados');
            $this->filters = false;
        }
    }

    public function resetFilters()
    {
        $this->filters = false;
        $this->statusFilter = '';
        $this->userName = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->mount(); // recarga los pedidos sin filtros
    }

    public function updatedOrders()
    {
        foreach ($this->orders as $order) {
            $order->save();
        }
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }

    public $returns = []; // Arreglo para almacenar los totales a devolver por pedido

    public function removeItem($itemId)
    {
        $item = OrderItem::find($itemId);

        if ($item) {
            $order = $item->order;

            // Si el pedido está pagado, devolver el stock y sumar al total de devolución
            if ($order->status === 'pagado' || $order->status === 'reembolsado') {
                // Devolver el stock a la tabla product_size
                \DB::table('product_size')
                    ->where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->increment('stock', $item->quantity);

                if (!is_array($this->totalreturn)) {
                    $this->totalreturn = [];
                }

                if (!isset($this->totalreturn[$order->id])) {
                    $this->totalreturn[$order->id] = 0;
                }

                $this->totalreturn[$order->id] += $item->price * $item->quantity;

            }

            // Eliminar el producto del pedido
            $item->delete();

            // Recalcular el total del pedido
            $order->total = $order->items()->sum(\DB::raw('price * quantity'));
            $order->save();

            // Verificar si el pedido ya no tiene productos y no hay devolución pendiente
            if ($order->items()->count() === 0 && (!isset($this->totalreturn[$order->id]) || $this->totalreturn[$order->id] == 0)) {
                $order->delete();
                $this->setMessage('Pedido #' . $order->id . ' eliminado porque no tiene productos.', 'warning');
            }
        }

        $this->mount(); // Recarga los pedidos
    }


    public function returned($orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            // Aquí puedes hacer la lógica para devolver el dinero, por ejemplo cambiar el estado del pedido
            $order->status = 'reembolsado'; // o lo que tú necesites
            $order->save();

            // Elimina el pedido si ya no tiene productos
            if ($order->items()->count() === 0) {
                $order->delete();
                $this->setMessage('Pedido #' . $order->id . ' eliminado porque no tiene productos.', 'warning');
            } else {
                $this->setMessage('Se ha procesado la devolución del dinero del Pedido #' . $order->id . '.', 'success');
            }
        }

        $this->mount(); // Recarga la vista
    }



    public function setMessage($message, $messageType = 'success')
    {
        $this->message = $message;
        $this->messageType = $messageType;
        $this->showMessage = true;
    }

    public function render()
    {
        return view('livewire.order-crud');
    }
}

