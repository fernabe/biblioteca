## Biblioteca

Aplicación para la gestión de una biblioteca.

## Requisitos

Debes tener instalado en tu sistema:
- Xampp, con PHP>=5.6.4
- Composer
- Git

## Pasos a realizar:

- Clonar el repositorio
```bash
git clone https://github.com/fernabe/biblioteca
```
Crear el archivo .env
```bash
cd proyecto
cp .env.example .env
```
Configurar el archivo .env de la siguiente manera:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=
```
Una vez creado el archivo .env, crear en el servidor local una base de datos con el nombre biblioteca.

Composer install
composer install
Generar clave
php artisan key:generate
Migraciones y seeders
composer dump-autoload
php artisan migrate
php artisan db:seed
Una vez realizados estos pasos, arrancamos un servidor local

php artisan serve
Acceso administrador:

http://localhost:8000/admin
Credenciales:

user: superadmin@labiblioteca.com
password: superadmin
Acceso usuario:

http://localhost:8000
Credenciales:

user: usuario@gmail.com
password: usuario
