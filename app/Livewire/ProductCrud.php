<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductCrud extends Component
{
    // Variables públicas para manejar los datos del producto y del formulario
    public $products, $product_id, $name, $description, $color, $gender, $style, $category, $price, $discount;

    public $categories = []; // Lista de categorías únicas disponibles
    public $sizes = []; // Array asociativo de talla_id => stock
    public $availableSizes; // Tallas disponibles según la categoría (ropa o zapatos)
    public $allSizes; // Todas las tallas disponibles sin filtrar

    public $view = 'list'; // Controla si se muestra la lista o el formulario

    /**
     * Renderiza la vista asociada al componente Livewire
     */
    public function render()
    {
        return view('livewire.product-crud');
    }

    /**
     * Se ejecuta al montar el componente.
     * Inicializa productos, tallas y categorías.
     */
    public function mount()
    {
        $this->products = Product::all(); // Carga todos los productos
        $this->allSizes = \App\Models\Size::all(); // Carga todas las tallas posibles
        $this->filterSizes(); // Filtra tallas según categoría actual (inicial)
        // Obtiene todas las categorías únicas existentes en productos para el filtro o selector
        $this->categories = Product::distinct()->pluck('category')->toArray();
    }

    /**
     * Filtra productos según ID o nombre introducido.
     * Si no se introduce ningún dato, muestra error y lista completa.
     */
    public function filter()
    {
        if (empty($this->product_id) && empty($this->name)) {
            session()->flash('error', 'Introduce algún dato de búsqueda');
            $this->products = Product::all();
            return;
        }

        $query = Product::query();

        // Filtra por ID exacto si se proporciona
        if (!empty($this->product_id)) {
            $query->where('id', $this->product_id);
        }

        // Filtra por nombre con búsqueda parcial usando LIKE
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        $this->products = $query->get();

        // Si no hay resultados, muestra mensaje y recarga todos los productos
        if ($this->products->isEmpty()) {
            session()->flash('error', 'Producto no encontrado');
            $this->products = Product::all();
        }
    }

    /**
     * Restablece filtros y carga todos los productos.
     */
    public function resetFilters()
    {
        $this->name = '';
        $this->product_id = '';
        $this->products = Product::all();
    }

    /**
     * Filtra tallas disponibles según la categoría actual:
     * - Si es "zapatos", solo devuelve tallas numéricas.
     * - Para ropa, devuelve tallas XS a XL.
     */
    public function filterSizes()
    {
        if (strtolower($this->category) === 'zapatos') {
            // Para zapatos, filtra solo tallas numéricas
            $this->availableSizes = $this->allSizes->filter(function ($size) {
                return is_numeric($size->name);
            });
        } else {
            // Para ropa, filtra tallas estándar XS, S, M, L, XL
            $this->availableSizes = $this->allSizes->filter(function ($size) {
                return in_array(strtolower($size->name), ['xs', 's', 'm', 'l', 'xl']);
            });
        }
    }

    /**
     * Se ejecuta automáticamente cuando se actualiza la categoría.
     * Refresca las tallas disponibles para la nueva categoría.
     */
    public function updatedCategory()
    {
        $this->filterSizes();
    }

    /**
     * Limpia todos los campos del formulario para una nueva entrada.
     */
    public function resetInputs()
    {
        $this->product_id = $this->name = $this->description = $this->color = $this->gender = $this->style = $this->category = '';
        $this->price = null;
        $this->sizes = [];
    }

    /**
     * Cambia la vista para mostrar el formulario de creación de producto
     * y limpia los campos para entrada nueva.
     */
    public function showCreateForm()
    {
        $this->resetInputs();
        $this->view = 'form';
    }

    /**
     * Carga datos de un producto existente para editar.
     * Además, carga los stocks asociados a las tallas.
     *
     * @param int $id ID del producto a editar
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->fill($product->toArray()); // Llena propiedades con datos del producto

        // Obtiene el stock para cada talla desde la tabla pivote 'product_size'
        $this->sizes = $product->sizes->pluck('pivot.stock', 'id')->toArray();

        $this->filterSizes(); // Actualiza tallas disponibles según categoría
        $this->view = 'form'; // Cambia a vista formulario
    }

    /**
     * Valida y guarda un nuevo producto en la base de datos.
     * También asocia las tallas y sus stocks en la tabla pivote.
     */
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        // Crea el producto con los datos validados
        $product = Product::create($this->validateData());

        // Recorre las tallas y adjunta solo las que tienen stock mayor que 0
        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $product->sizes()->attach($sizeId, ['stock' => $stock]); // attach() para nuevas relaciones
            }
        }

        $this->resetInputs();
        session()->flash('message', 'Producto creado correctamente.');
        $this->view = 'list';
    }

    /**
     * Valida y actualiza un producto existente.
     * Sincroniza las tallas y stocks relacionados.
     */
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($this->product_id);
        $product->update($this->validateData());

        // Construye un array para sincronizar tallas con stocks
        $syncData = [];
        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $syncData[$sizeId] = ['stock' => $stock];
            }
        }

        // sync() reemplaza relaciones existentes por las nuevas (borra las anteriores que no estén aquí)
        $product->sizes()->sync($syncData);

        $this->resetInputs();
        session()->flash('message', 'Producto actualizado.');
        $this->view = 'list';
    }

    /**
     * Cancela la edición o creación y vuelve a la lista de productos.
     */
    public function cancel()
    {
        $this->resetInputs();
        $this->view = 'list';
    }

    /**
     * Elimina un producto dado su ID.
     *
     * @param int $id ID del producto a eliminar
     */
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Producto eliminado.');
    }

    /**
     * Retorna los datos validados comunes del producto para crear o actualizar.
     *
     * @return array Datos del producto
     */
    private function validateData()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'gender' => $this->gender,
            'style' => $this->style,
            'category' => $this->category,
            'price' => $this->price,
            'discount' => $this->discount,
        ];
    }
}
