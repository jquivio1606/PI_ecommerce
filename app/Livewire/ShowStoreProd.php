<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Size;

class ShowStoreProd extends Component
{
    public $gender;
    public $categories = [];
    public $color;
    public $priceMin;
    public $priceMax;
    public $sizes = []; // Array para las tallas seleccionadas
    public $availableSizes; // Lista de todas las tallas disponibles
    public $style;

    // Listas dinámicas
    public $gendersList = [];
    public $categoriesList = [];
    public $colorsList = [];
    public $stylesList = [];

    public $orderBy;

    public $onlyOffers = false;

    public $prodFiltrado;
    public $filters = false;

    public function render()
    {
        $products = $this->prodFiltrado ?? Product::all(); // Mostrar productos filtrados si existen
        return view('livewire.show-store-prod', compact('products'));
    }

    public function mount()
    {
        // Inicializamos las listas de filtros dinámicos
        $this->gendersList = Product::distinct()->pluck('gender')->toArray();
        $this->categoriesList = Product::distinct()->pluck('category')->toArray();
        $this->colorsList = Product::distinct()->pluck('color')->toArray();
        $this->stylesList = Product::distinct()->pluck('style')->toArray();

        // Inicializamos las tallas disponibles (de la tabla Size)
        $this->availableSizes = Size::all();
    }

    public function filter()
    {
        // Inicializamos la consulta
        $query = Product::query();

        $this->filters = false;
        $this->prodFiltrado = null;

        // Género
        if (!empty($this->gender)) {
            $query->where('gender', $this->gender);
            $this->filters = true;
        }

        // Categorías (pueden ser múltiples)
        if (!empty($this->categories)) {
            $query->whereIn('category', $this->categories);
            $this->filters = true;
        }

        // Color
        if (!empty($this->color)) {
            $query->where('color', $this->color);
            $this->filters = true;
        }

        // Estilo
        if (!empty($this->style)) {
            $query->where('style', $this->style);
            $this->filters = true;
        }

        // Precio mínimo
        if (!empty($this->priceMin)) {
            $query->where('price', '>=', $this->priceMin);
            $this->filters = true;
        }

        // Precio máximo
        if (!empty($this->priceMax)) {
            $query->where('price', '<=', $this->priceMax);
            $this->filters = true;
        }

        // Filtro por tallas (relación many-to-many)
        if (!empty($this->sizes)) {
            $query->whereHas('sizes', function ($q) {
                $q->whereIn('name', $this->sizes);
            });
            $this->filters = true;
        }

        // Ofertas (productos con discount > 0)
        if ($this->onlyOffers) {
            $query->where('discount', '>', 0);
            $this->filters = true;
        }


        // Comprobamos si se aplicaron filtros
        if (!$this->filters) {
            session()->flash('error', 'Introduce algún dato para filtrar');
            $this->prodFiltrado = [];
            return;
        }

        // Ejecutamos la consulta y almacenamos el resultado
        $this->prodFiltrado = $query->get();

        if ($this->prodFiltrado->isEmpty()) {
            session()->flash('error', 'No se ha encontrado ningún producto con esas características.');
            $this->filters = false;
        }
    }

    public function resetFilters()
    {
        $this->gender = null;
        $this->categories = [];
        $this->color = '';
        $this->priceMin = null;
        $this->priceMax = null;
        $this->sizes = []; // Reseteamos las tallas
        $this->filters = false;
        $this->prodFiltrado = null;
    }
}
