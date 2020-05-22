# Convocatoria-Auxiliares
El sistema realizara la administracion de las convocatorias de auxiliares en la UMSS

## Sistema-Auxiliares
### Instalacion
- git clone https://github.com/agaak/Convocatoria-Auxiliares.git
- composer install
- php artisan key:generate
- php artisan serve

### Configuracion de la base de datos a Postgres de XAMPP
- abrir XAMPP 
- apache  boton "config" abrir PHP(php.ini)
- buscar:
	- ;extension=php_pdo_pgsql.dll
	- ;extension=php_pgsql.dll
- quitar ";"
- php artisan migrate
