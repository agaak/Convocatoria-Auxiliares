# Convocatoria-Auxiliares
El sistema realizara la administracion de las convocatorias de auxiliares en la UMSS

## Sistema-Auxiliares
### Instalacion

- git clone https://github.com/agaak/tis_auxiliares.git
- cd tis_auxiliares
- crear el nombre del archivo ".env" y copiar el contenido de ".env.example"
- composer install
- composer update
- php artisan key:generate
- php artisan serve

### Configuracion de la base de datos a Postgres de XAMPP
- abrir XAMPP 
- apache  boton "config" abrir PHP(php.ini)
- buscar:
	- ;extension=php_pdo_pgsql.dll
	- ;extension=php_pgsql.dll
- quitar ";"
