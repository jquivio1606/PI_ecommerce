# PI_ecommerce
Repositorio del Proyecto Integrado de DAW

## Requisitos Previos
- **Instalar:** 
    - XAMPP: Para tener el servidor web y base de datos (MySQL o MariaDB).
    - Composer: Para gestionar las dependencias de PHP.
    - Laravel: Instalado a través de Composer.
    - Node.js y NPM: Si utilizas tecnologías de frontend como Vue.js, React, o necesitas compilar archivos CSS/JS.

- **Descargar dependencias:**
    
    Php: composer install

    De frontend: npm install y npm run dev

- **Crear el archivo .env**
    cp .env.example .env (si existe el archivo .env.example)

- **Generar la clave de la aplicación Laravel:**
    php artisan key:generate

- **Configurar la base de datos en .env:**
    
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=ecommercedb 
    - DB_USERNAME=root 
    - DB_PASSWORD=

- **Realizar la migración de las tablas:**
    php artisan migrate

- **Insertar productos en la bd:**
    php artisan db:seed
    
## Iniciar el servidor de Laravel
php artisan serve

## Dentro de la web
(Si se han cargado los seeders) Para iniciar sesión hay dos usuarios creados:
- TestUser: 

    email: test@example.com

    password: 123456789
- AdminUser: 

    email: admin@example.com

    password: 123456789

*Nota: Todavía no está hecho la parte de rol:Aministrador y rol:Usuario

## Urls funcionales
- **De cara al usuario:** (Se puede llegar a ellas navegando por la web)

    [Página principal](http://127.0.0.1:8000/)  
    [Tienda](http://127.0.0.1:8000/tienda)  
    [Carrito](http://127.0.0.1:8000/carrito)  
    [Detalles de un producto](http://127.0.0.1:8000/productos/{id})  
    [Confirmación del pedido](http://127.0.0.1:8000/confirmacionPedido)

- **De cara al administrador:** (Sólo se pueden acceder mediante la url)

    [Gestión de productos](http://127.0.0.1:8000/productos)  
    [Gestión de pedidos](http://127.0.0.1:8000/pedidos)


# PROBLEMAS A SOLUCIONAR:

- **Cuando se filtra 2 veces desaparece los botones o al cosas del add-to-cart**  (SOLUCIONADO)
- **Al descargar el proyecto del git surgen problemas con las vistas que crea laravel:** No se han descargado bien las dependencias del front, y tengo problema con el vite en otros ordenadores.