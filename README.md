# Time Control Project

Este proyecto es un sistema para el control de horas trabajadas. A continuación se presentan los pasos para clonar el repositorio y ejecutar el proyecto correctamente.

## Requisitos

- **PHP** >= 8.0
- **Composer** >= 2.0
- **Node.js** >= 12.x
- **NPM** o **Yarn**
- **MySQL** o cualquier base de datos soportada por Laravel
- **Git**

## Clonar el repositorio

1. Abre tu terminal y navega hasta el directorio donde deseas clonar el proyecto.
2. Ejecuta el siguiente comando:

   ```bash
   git clone https://github.com/usuario/time_control.git

3. Ingresa al directorio del proyecto:

cd time_control

4.  Instalar dependencias de PHP
Usa Composer para instalar las dependencias de Laravel:

composer install

5. Configurar el archivo .env
Copia el archivo .env.example como .env:

cp .env.example .env
çAbre el archivo .env y configura las siguientes variables:

Base de datos:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=time_control
DB_USERNAME=root
DB_PASSWORD=

php artisan key:generate

php artisan migrate

npm install

npm run dev

php artisan serve





