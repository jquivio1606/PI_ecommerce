<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;


class ProductCrud extends Component
{
    public $products, $product_id, $name, $description, $color, $gender, $style, $category, $price;

    public $sizes = []; // array para asociar tamaños y stocks
    public $availableSizes; // lista de todas las tallas
    public $view = 'list';

    public $prodFiltrado = [];
    public $filters = false;
    public function filter()
    {
        // Si no se ha introducido ningún dato de búsqueda
        if (empty($this->search) && empty($this->product_id) && empty($this->name)) {
            session()->flash('error', 'Introduce algún dato de búsqueda');
            $this->prodFiltrado = [];
            $this->filters = false;
            return;
        }

        // Inicializamos la consulta
        $query = Product::query();

        // Filtro por ID si se ha indicado
        if (!empty($this->product_id)) {
            $query->where('id', $this->product_id);
            $this->filters = true;
        }

        // Filtro por nombre si se ha indicado
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
            $this->filters = true;
        }

        // Guardamos los productos filtrados
        $this->prodFiltrado = $query->get();

        // Si no hay resultados
        if ($this->prodFiltrado->isEmpty()) {
            session()->flash('error', 'Producto no encontrado');
            $this->filters = false;

        }
    }

    public function resetFilters()
    {
        $this->filters = false;
        $this->name = '';
        $this->product_id = '';
    }


    public function mount()
    {
        $this->availableSizes = \App\Models\Size::all();
    }
    public function render()
    {
        $this->products = Product::all();
        return view('livewire.product-crud');
    }

    public function resetInputs()
    {
        $this->product_id = $this->name = $this->description = $this->color = $this->gender = $this->style = $this->category = '';
        $this->price = null;
        $this->sizes = [];
    }

    public function showCreateForm()
    {
        $this->resetInputs();
        $this->view = 'form';
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->fill($product->toArray());

        // Rellenar el array con los stocks de tallas
        $this->sizes = $product->sizes->pluck('pivot.stock', 'id')->toArray();

        $this->view = 'form';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($this->validateData());

        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $product->sizes()->attach($sizeId, ['stock' => $stock]);
            }
        }

        $this->resetInputs();
        session()->flash('message', 'Producto creado correctamente.');
        $this->view = 'list';
    }
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($this->product_id);
        $product->update($this->validateData());

        $syncData = [];
        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $syncData[$sizeId] = ['stock' => $stock];
            }
        }

        $product->sizes()->sync($syncData);

        $this->resetInputs();
        session()->flash('message', 'Producto actualizado.');
        $this->view = 'list';
    }

    public function cancel()
    {
        $this->resetInputs();
        $this->view = 'list';
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Producto eliminado.');
    }

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
        ];
    }

}
