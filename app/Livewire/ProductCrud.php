<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Size;
use App\Models\Image;
use Livewire\Component;

class ProductCrud extends Component
{
    use WithFileUploads;

    // Variables públicas para manejar los datos del producto y del formulario
    public $products, $product_id, $name,
    $description, $color, $gender, $style,
    $category, $price, $discount;

    public $images = [];
    public $imagesDB = [];

    public $newCategory = '';
    public $newSize = '';
    public $categories = [];                                                    // Lista de categorías únicas disponibles
    public $sizes = [];                                                 // Array asociativo de talla_id => stock
    public $availableSizes;                                             // Tallas disponibles según la categoría (ropa o zapatos)
    public $allSizes;                                               // Todas las tallas disponibles sin filtrar

    public $view = 'list';                                              // Controla si se muestra la lista o el formulario

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
        $this->allSizes = Size::all(); // Carga todas las tallas posibles

        $this->filterSizes(); // Filtra tallas según categoría actual (inicial)

        // Obtiene todas las categorías únicas existentes en productos para el filtro o selector
        $this->categories = Product::distinct()->pluck('category')->toArray();

        $this->availableSizes = Size::all();
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
     * Limpia todos los campos del formulario para una nueva entrada.
     */
    public function resetInputs()
    {
        $this->product_id = $this->name = $this->description = $this->color = $this->gender = $this->style = $this->category = $this->newSize = $this->newCategory = '';
        $this->price = null;
        $this->sizes = [];
        $this->images = [];      // Limpia imágenes cargadas nuevas
        $this->imagesDB = [];    // Limpia imágenes guardadas en BD
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
     * Filtra tallas disponibles según la categoría actual:
     * - Si es "calzado", solo devuelve tallas numéricas.
     * - Para ropa, devuelve tallas XS a XL.
     */
    public function filterSizes()
    {
        if (strtolower($this->category) === 'calzado') {
            // Para calzado, filtra solo tallas numéricas
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
     * Añade una nueva categoría si no existe, formatea el nombre y asigna la categoría actual.
     * Muestra mensaje y limpia el campo.
     */
    public function addNewCategory()
    {
        // Limpia espacios y convierte el texto a formato "Título" (primera letra mayúscula)
        $name = trim(mb_convert_case($this->newCategory, MB_CASE_TITLE));

        // Si el nombre no está vacío y no existe ya en el array de categorías
        if ($name && !in_array($name, $this->categories)) {
            // Añade la nueva categoría al listado de categorías
            $this->categories[] = $name;

            // Asigna la nueva categoría seleccionada para usar en el formulario
            $this->category = $name;

            // Muestra un mensaje flash para informar al usuario que la categoría fue añadida
            session()->flash('message', 'Nueva categoría añadida.');
        }

        // Limpia el campo input de nueva categoría para que quede vacío
        $this->newCategory = '';
    }

    /**
     * Añade una nueva talla, la busca o crea en BD, la añade si no existe,
     * inicializa stock a 0, y limpia el campo.
     */
    public function addNewSize()
    {
        // Limpia espacios y convierte el texto a MAYÚSCULAS para uniformidad
        $name = trim(mb_strtoupper($this->newSize));

        // Si el nombre no está vacío
        if ($name) {
            // Busca o crea una nueva talla en la tabla sizes con ese nombre
            $size = Size::firstOrCreate(['name' => $name]);

            // Comprueba que la talla no esté ya en el array de tallas disponibles
            if (!collect($this->availableSizes)->contains('id', $size->id)) {
                // Si no está, la añade a la lista de tallas disponibles
                $this->availableSizes[] = $size;
            }

            // Inicializa el stock de esta talla nueva a 0 en el array sizes (para el formulario)
            $this->sizes[$size->id] = 0;
        }

        // Limpia el campo input de nueva talla para que quede vacío
        $this->newSize = '';
    }

    public function removePreviewImage($key)
    {
        if (isset($this->images[$key]) && is_object($this->images[$key])) {
            unset($this->images[$key]);
            // Reindexar el array para evitar huecos y mantenerlo limpio
            $this->images = array_values($this->images);
        }
    }


    public function deleteImage($id)
    {
        $image = Image::find($id);

        if ($image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();

            $this->imagesDB = Image::where('product_id', $this->product_id)->get();
        }
    }


    /**
     * Guarda las imágenes cargadas, asociándolas al producto dado.
     *
     * @param int $productId ID del producto
     */
    private function saveImages($productId)
    {

        $validImages = collect($this->images)
            ->filter(fn($img) => $img instanceof \Illuminate\Http\UploadedFile)
            ->values();

        if ($validImages->isEmpty()) {
            return;
        }

        $this->validate([
            'images.*' => 'image|max:2048',
        ]);

        foreach ($this->images as $image) {
            $path = $image->store('products', 'public');
            Image::create([
                'url' => $path,
                'product_id' => $productId,
            ]);
        }

        $this->images = [];
        $this->dispatch('clearFileInput');

    }

    /**
     * Carga datos de un producto existente para editar.
     * Además, carga los stocks asociados a las tallas.
     *
     * @param int $id ID del producto a editar
     */
    public function edit($id)
    {

        $product = Product::with('images')->findOrFail($id);
        $this->product_id = $product->id;
        $this->fill($product->toArray());

        $this->imagesDB = $product->images;

        $this->sizes = $product->sizes->pluck('pivot.stock', 'id')->toArray();

        $this->availableSizes = Size::all();
        $this->categories = Product::distinct()->pluck('category')->toArray();
        $this->view = 'form';
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
            'discount' => 'nullable|numeric|min:0', // nullable para permitir vacío
            'sizes' => [
                'required',
                function ($attribute, $value, $fail) {
                    $hasStock = false;
                    foreach ($value as $stock) {
                        if ($stock > 0) {
                            $hasStock = true;
                            break;
                        }
                    }
                    if (!$hasStock) {
                        $fail('Debes asignar stock a al menos una talla.');
                    }
                }
            ],
        ]);

        // Si se ingresó una nueva categoría, guárdala
        if (!empty($this->newCategory)) {
            $this->category = trim($this->newCategory);
        }

        // Si se ingresó una nueva talla, guárdala
        if (!empty($this->newSize)) {
            $size = Size::firstOrCreate(['name' => trim($this->newSize)]);
            $this->sizes[$size->id] = 0; // inicializa stock en 0 para esa talla
        }

        $product = Product::create($this->validateData());

        // Guardar tallas con su stock
        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $product->sizes()->attach($sizeId, ['stock' => $stock]);
            }
        }

        // Guardar imágenes
        $this->saveImages($product->id);

        // Recargar imágenes de BD (opcional si vas a mostrar inmediatamente)
        $this->imagesDB = Image::where('product_id', $product->id)->get();

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
            'discount' => 'nullable|numeric|min:0', // nullable para permitir vacío
            'sizes' => [
                'required',
                function ($attribute, $value, $fail) {
                    $hasStock = false;
                    foreach ($value as $stock) {
                        if ($stock > 0) {
                            $hasStock = true;
                            break;
                        }
                    }
                    if (!$hasStock) {
                        $fail('Malamente');
                    }
                }
            ],
        ]);

        if (!empty($this->newCategory)) {
            $this->category = trim($this->newCategory);
        }

        if (!empty($this->newSize)) {
            $size = Size::firstOrCreate(['name' => trim($this->newSize)]);
            $this->sizes[$size->id] = 0;
        }

        $product = Product::findOrFail($this->product_id);
        $product->update($this->validateData());

        $syncData = [];
        foreach ($this->sizes as $sizeId => $stock) {
            if ($stock > 0) {
                $syncData[$sizeId] = ['stock' => $stock];
            }
        }

        $product->sizes()->sync($syncData);

        // Guardar imágenes asociadas SOLO si hay imágenes nuevas
        if (!empty($this->images)) {
            $this->saveImages($product->id);
        }

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
            'name' => trim(mb_convert_case($this->name, MB_CASE_TITLE)),
            'description' => $this->description,
            'color' => trim(mb_convert_case($this->color, MB_CASE_TITLE)),
            'gender' => trim(mb_convert_case($this->gender, MB_CASE_TITLE)),
            'style' => trim(mb_convert_case($this->style, MB_CASE_TITLE)),
            'category' => $this->category,
            'price' => $this->price,
            'discount' => $this->discount,
        ];

    }
}
