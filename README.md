# Content Media - Backend - Prueba Tecnica

Desarrollado por Said Ian Ramses Suybate Vidal (SaidSuyv)

# Detalles de desarrollo

- Laravel v12
- Soporte SQLite
- Composer v2.8.6
- PHP v8.2.28

**Testeada con POSTMAN**

# Descripcion

Esta es una API de prueba tecnica basada que consta de una tienda online que gestiona Libros de cualquier tipo.

Se puede obtener una visualizacion completa de las rutas y usos a traves del archivo [OpenAPI.yml](./openapi.yml) con formato OpenAPI v3.

Utiliza Factory para poder poblar la base de datos con Libros DEMO de modo que pueda funcionar la aplicacion y se puedan ejecutar peticiones.

# Instalacion

1. Clonar el repositorio
```bash
git clone https://github.com/SaidSuyv/ContentMedia_Backend
```
2. Instalar dependencias
```bash
cd ContentMedia_Backend
composer install
```
3. Migrar y poblar base de datos
```bash
php artisan migrate --seed
```
4. Ejecutar servidor
```bash
php artisan serve
```

# OBLIGATORIO
El servidor debe ejecutarse en el puerto 8000 para que pueda funcionar con la [aplicaction web](https://github/SaidSuyv/ContentMedia_Frontend).

___

SaidSuyv - 2025