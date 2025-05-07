# PI_ecommerce
Repositorio del Proyecto Integrado de DAW

## Requisitos Previos
- Instalar XAMPP: Asegúrate de tener XAMPP instalado en tu máquina. Puedes descargarlo desde aquí.

- Tener el archivo .env con los datos correctos:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommercedb  
    DB_USERNAME=root         
    DB_PASSWORD=

- Realizar la migración de las tablas:
    php artisan migrate

- Insertar productos en la bd:
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
- De cara al usuario: (Se puede llegar a ellas navegando por la web)
    http://127.0.0.1:8000/
    http://127.0.0.1:8000/tienda
    http://127.0.0.1:8000/carrito
    http://127.0.0.1:8000/productos/{id}
    http://127.0.0.1:8000/confirmacionPedido

- De cara al administrador: (Sólo se pueden acceder mediante la url)
    http://127.0.0.1:8000/productos
    http://127.0.0.1:8000/pedidos
