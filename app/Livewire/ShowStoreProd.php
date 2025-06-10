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
    public $sizes = [];           // Array con nombres de tallas seleccionadas
    public $availableSizes;       // Colección de todas las tallas disponibles
    public $style;

    // Listas para mostrar opciones de filtros dinámicos
    public $gendersList = [];
    public $categoriesList = [];
    public $colorsList = [];
    public $stylesList = [];

    public $orderBy;

    public $onlyOffers = false;         // Filtro para mostrar solo productos en oferta

    public $prodFiltrado;         // Colección de productos filtrados

    /**
     * Inicializa las listas de filtros dinámicos y tallas disponibles
     */
    public function mount()
    {
        // Obtenemos valores distintos de cada atributo para los filtros
        $this->gendersList = Product::distinct()->pluck('gender')->toArray();
        $this->categoriesList = Product::distinct()->pluck('category')->toArray();
        $this->colorsList = Product::distinct()->pluck('color')->toArray();
        $this->stylesList = Product::distinct()->pluck('style')->toArray();

        // Todas las tallas disponibles (tabla Size)
        $this->availableSizes = Size::all();
    }

    /**
     * Aplica los filtros a la consulta de productos
     */
    public function filter()
    {
        $query = Product::query();

        $this->prodFiltrado = null;

        // Aplicamos filtro por género
        if (!empty($this->gender)) {
            $query->where('gender', $this->gender);
        }

        // Filtro por categorías (pueden ser múltiples)
        if (!empty($this->categories)) {
            $query->whereIn('category', $this->categories);
        }

        // Filtro por color
        if (!empty($this->color)) {
            $query->where('color', $this->color);
        }

        // Filtro por estilo
        if (!empty($this->style)) {
            $query->where('style', $this->style);
        }

        // Precio mínimo
        if (!empty($this->priceMin)) {
            $query->where('price', '>=', $this->priceMin);
        }

        // Precio máximo
        if (!empty($this->priceMax)) {
            $query->where('price', '<=', $this->priceMax);
        }

        // Filtro por tallas (relación many-to-many)
        if (!empty($this->sizes)) {
            $query->whereHas('sizes', function ($q) {
                $q->whereIn('name', $this->sizes);
            });
        }

        // Mostrar solo productos en oferta
        if ($this->onlyOffers) {
            $query->where('discount', '>', 0);
        }

        // Si no hay filtros aplicados, mostramos error y limpiamos resultados
        if (
            empty($this->gender) && empty($this->categories) && empty($this->color) && empty($this->style) &&
            empty($this->priceMin) && empty($this->priceMax) && empty($this->sizes) && !$this->onlyOffers
        ) {
            session()->flash('error', 'Introduce algún dato para filtrar');
            $this->prodFiltrado = collect(); // Mejor usar colección vacía que array
            return;
        }

        // Ejecutamos la consulta y guardamos los productos filtrados
        $this->prodFiltrado = $query->with('images')->get();

        // Si no hay resultados, mostramos mensaje de error
        if ($this->prodFiltrado->isEmpty()) {
            session()->flash('error', 'No se ha encontrado ningún producto con esas características.');
        }
    }

    /**
     * Reinicia todos los filtros y la lista filtrada
     */
    public function resetFilters()
    {
        $this->gender = null;
        $this->categories = [];
        $this->color = null;
        $this->priceMin = null;
        $this->priceMax = null;
        $this->sizes = [];
        $this->style = null;
        $this->onlyOffers = false;
        $this->prodFiltrado = null;
    }

    /**
     * Renderiza la vista con los productos (filtrados o todos)
     */
    public function render()
    {
        $products = $this->prodFiltrado ?? Product::with('images')->get();
        return view('livewire.show-store-prod', compact('products'));
    }

}
