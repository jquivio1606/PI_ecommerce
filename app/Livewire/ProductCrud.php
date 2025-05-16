<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;


class ProductCrud extends Component
{
    public $products, $product_id, $name, $description, $color, $gender, $style, $category, $price, $discount;

    public $categories = [];

    public $sizes = []; // array para asociar tamaños y stocks
    public $availableSizes; // lista de todas las tallas
    public $allSizes; // todas las tallas sin filtrar

    public $view = 'list';

    public function render()
    {
        return view('livewire.product-crud');
    }


    public function mount()
    {
        $this->products = Product::all();
        $this->allSizes = \App\Models\Size::all();
        $this->filterSizes();
        $this->categories = Product::distinct()->pluck('category')->toArray();
    }

    public function filter()
    {
        if (empty($this->product_id) && empty($this->name)) {
            session()->flash('error', 'Introduce algún dato de búsqueda');
            $this->products = Product::all();
            return;
        }

        $query = Product::query();

        if (!empty($this->product_id)) {
            $query->where('id', $this->product_id);
        }

        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        $this->products = $query->get();

        if ($this->products->isEmpty()) {
            session()->flash('error', 'Producto no encontrado');
            $this->products = Product::all();
        }
    }

    public function resetFilters()
    {
        $this->name = '';
        $this->product_id = '';
        $this->products = Product::all();
    }

    public function filterSizes()
    {
        if (strtolower($this->category) === 'zapatos') {
            $this->availableSizes = $this->allSizes->filter(function ($size) {
                return is_numeric($size->name);
            });
        } else {
            $this->availableSizes = $this->allSizes->filter(function ($size) {
                return in_array(strtolower($size->name), ['xs', 's', 'm', 'l', 'xl']);
            });
        }
    }

    public function updatedCategory()
    {
        $this->filterSizes();
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

        $this->sizes = $product->sizes->pluck('pivot.stock', 'id')->toArray();

        $this->filterSizes(); // actualizar tallas según la categoría
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
            'discount' => $this->discount,
        ];
    }

}
