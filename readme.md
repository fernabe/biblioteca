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
- Crear el archivo .env
```bash
cd proyecto
cp .env.example .env
```
- Configurar el archivo .env de la siguiente manera:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=
```
Debes cambiar el nombre de usuario y password en caso de que tengas otros diferentes para acceder al servidor.
Dentro del archivo .env tambien configuraremos el envio de mails para un entorno de desarrollo local:
```bash
MAIL_DRIVER=log
MAIL_HOST=null
MAIL_PORT=null
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```
Una vez creado el archivo .env y configurado el archivo .env, crear en el servidor local una base de datos con el nombre biblioteca.

- Composer install:
```bash
composer install
```
- Generar clave:
```bash
php artisan key:generate
```
- Migraciones y seeders:
```bash
composer dump-autoload
php artisan migrate
php artisan db:seed
```
Una vez realizados estos pasos, arrancamos un servidor local
```bash
php artisan serve
```
Acceso administrador:
```bash
http://localhost:8000/admin
```
Credenciales:
```bash
user: superadmin@labiblioteca.com
password: superadmin
```
Acceso usuario:
```bash
http://localhost:8000
```
Credenciales:
```bash
user: usuario@gmail.com
password: usuario
```
