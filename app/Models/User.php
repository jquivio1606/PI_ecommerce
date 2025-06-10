<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /**
     * Trait para usar factories en tests y seeders
     * y para enviar notificaciones al usuario.
     */
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',             // Define el rol del usuario (e.g. admin o usuario normal)
    ];

    /**
     * Atributos que deben ocultarse al serializar (p. ej. en JSON).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',   // Token para mantener la sesión iniciada
    ];

    /**
     * Casting de atributos para convertir tipos automáticamente.
     * 'email_verified_at' se convierte a objeto datetime,
     * 'password' se guarda como hash automáticamente.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación 1:1 con el carrito de compras.
     * Un usuario tiene un carrito.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Relación 1:N con pedidos.
     * Un usuario puede tener muchos pedidos.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Devuelve las iniciales del nombre completo del usuario.
     * Ejemplo: "Juan Perez" => "JP"
     *
     * Esta línea:
     *  - Explode divide el nombre por espacios en array,
     *  - Map extrae la primera letra de cada palabra,
     *  - Implode junta las iniciales.
     *
     * @return string
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }


    /**
     * Devuelve el carrito del usuario, o lo crea si no existe.
     *
     * @return Cart
     */
    public function getOrCreateCart()
    {
        return $this->cart()->firstOrCreate([]);
    }
}
