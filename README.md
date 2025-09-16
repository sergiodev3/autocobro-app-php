# 🚀 Autocobro PHP

![GitHub repo size](https://img.shields.io/github/repo-size/sergiodev3/autocobro-app-php)
![GitHub last commit](https://img.shields.io/github/last-commit/sergiodev3/autocobro-app-php)
![GitHub](https://img.shields.io/github/license/sergiodev3/autocobro-app-php)

Sistema web de **autocobro**, desarrollado en PHP y MySQL.

---

## ✨ Características

- 👤 Registro e inicio de sesión de usuarios
- 📦 Administración de productos (agregar, editar, eliminar)
- 🖼️ Carga y edición de imágenes de productos
- 🛒 Carrito de compras y generación de tickets
- 📈 Historial de compras y protección de integridad referencial

---

## 🛠️ Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/sergiodev3/autocobro-app-php.git
   ```
2. **Importa la base de datos** desde `config/database.sql` usando phpMyAdmin.
3. **Configura las credenciales** en `config/database.php` (usa `config/database.example.php` como guía).
4. **Asegúrate que la carpeta `images/` tenga permisos de escritura.**

---

## 📁 Estructura del proyecto

```plaintext
app/
  controllers/
  models/
  views/
config/
css/
images/
js/
public/
index.php
.htaccess
```

---

## 🗄️ Base de datos

Importa el archivo `config/database.sql` para crear la estructura necesaria.

```bash
mysql -u usuario -p nombre_base_de_datos < config/database.sql
```

---

## ⚠️ Seguridad

- Las credenciales reales están ignoradas por `.gitignore`.
- Usa `config/database.example.php` para compartir la estructura de conexión.

---

## 👨‍💻 Créditos

Desarrollado por [sergiodev3](https://github.com/sergiodev3).

---

## 📬 Contacto

¿Tienes dudas o sugerencias?  
Abre un issue o contáctame en [sergio.sanchez@cbtis258.edu.mx](mailto:sergio.sanchez@cbtis258.edu.mx)
