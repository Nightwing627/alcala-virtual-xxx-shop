# LaraVue

Proyecto base elaborado con Laravel + VueJS.

## Getting Started

Antes de tratar de montar el proyecto es necesario instalar las librerias de Composer en el servidor donde se ejecutara el codigo.

### Prerequisites

Para usar este proyecto es necesario tener instalado los siguientes paquetes.

```
*Terminal UNIX

Para Backend:
*PHP > 7.0
*Componser

Para Frontend
*NPM

```

### Installing

Lo primero que necesitamos para instalar el proyecto es instalar las librerias PHP con Composer.

Ejecuta en terminal:

```
composer install
```

Despues es necesario crear las tablas con las migraciones de Laravel

```
php artisan migrate
```

Por ultimo es necesario sembrar los datos a la base de datos:

```
php artisan db:seed
```

Con esto ya estaria instalado a nivel Backend el proyecto.


## Authors

* **Ivan Agosto** - *Trabajo inicial* - [Agosto182](https://bitbucket.org/agosto182)


## License

Este proyecto esta bajo la Licencia **Copyleft** respetando respectivamente las licencias de [Laravel](https://laravel.com/) y [VueJS](https://vuejs.org/).

