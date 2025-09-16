# Autocobro PHP

Sistema web de autocobro para tiendas y comercios, desarrollado en PHP puro y MySQL.

## Características

- Registro e inicio de sesión de usuarios
- Administración de productos (agregar, editar, eliminar)
- Carga y edición de imágenes de productos
- Carrito de compras y generación de tickets
- Historial de compras y protección de integridad referencial

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/sergiodev3/autocobro-app-php.git
   ```
2. Importa la base de datos desde `config/database.sql` usando phpMyAdmin.
3. Copia `config/database.example.php` a `config/database.php` y agrega tus credenciales:

   ```php
   private $host = 'localhost';
   private $db_name = 'tu_base_de_datos';
   private $username = 'tu_usuario';
   private $password = 'tu_contraseña';
   ```

4. Asegúrate que la carpeta `images/` tenga permisos de escritura.

## Estructura del proyecto

```
app/
  controllers/
  models/
  views/
config/
css/
images/
js/
index.php
.htaccess
```

## Créditos

Desarrollado por sergiodev3.
