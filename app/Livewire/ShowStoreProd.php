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

        // Verificamos si no se ha introducido ningún filtro
        if (
            empty($this->gender) &&
            empty($this->categories) &&
            empty($this->color) &&
            empty($this->priceMin) &&
            empty($this->priceMax) &&
            empty($this->sizes) // Agregar la validación para tallas
        ) {
            session()->flash('error', 'Introduce algún dato para filtrar');
            $this->prodFiltrado = [];
            $this->filters = false;
            return;
        }

        $query = Product::query();

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


        // Filtro por tallas (relación many-to-many)
        if (!empty($this->sizes)) {
            $query->whereHas('sizes', function ($q) {
                $q->whereIn('name', $this->sizes); // Compara las tallas seleccionadas
            });
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



        // Ejecutamos la consulta y almacenamos los productos filtrados
        $this->prodFiltrado = $query->get();

        if ($this->prodFiltrado->isEmpty()) {
            session()->flash('error', 'No se ha encontrado ningún producto con esas características.');
            $this->filters = false;
        }
    }

    public function resetFiltros()
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
