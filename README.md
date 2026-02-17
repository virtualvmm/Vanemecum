# Vanemecum

<p align="center">
<img src="https://raw.githubusercontent.com/virtualvmm/Vanemecum/main/public/logo.png" width="200" alt="Vanemecum Logo">
</p>

**Guía de Virus, Bacterias y Hongos**  

Proyecto de **Trabajo de Fin de FP** desarrollado en **Laravel** y **PHP**. Este proyecto es una guía educativa sobre distintos microorganismos.

---

## 📌 Características

- Consulta de virus, bacterias y hongos.
- Información detallada de cada microorganismo (nombre, descripción, características, imágenes, etc.).
- Sistema básico de gestión de datos (CRUD) para administrar la información.
- Base de datos MySQL.
- Interfaz limpia y sencilla.

---

## 💻 Tecnologías

- Laravel 10
- PHP 8.x
- MySQL
- Composer
- Git / GitHub

---

## ⚙️ Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/virtualvmm/Vanemecum.git
cd Vanemecum
```

2. Instalar dependencias y configurar entorno:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Configurar la base de datos en `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD) y ejecutar migraciones:

```bash
php artisan migrate
```

4. Poblar la base de datos (patógenos, tipos, síntomas, usuario admin):

```bash
php artisan db:seed
```

5. Asignar las imágenes de `public/images/patogenos/` a cada patógeno (las imágenes **sí van en el repositorio**; este comando enlaza cada archivo con su patógeno por nombre):

```bash
php artisan patogenos:asignar-imagenes
```

6. (Opcional) Enlace para archivos en `storage`. Solo necesario si la app usa almacenamiento además de las imágenes de patógenos:

```bash
php artisan storage:link
```
