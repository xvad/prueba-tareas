# 🧪 Prueba Técnica GUX - Sistema de Tareas

Este proyecto es una **prueba técnica** para la empresa **GUX**, que consiste en un sistema de tareas con backend en **Laravel 10** y frontend en **Next.js 15**. La aplicación puede ejecutarse tanto con **Docker** como localmente sin contenedores.

## 🚀 Tecnologías Utilizadas

- **Backend**: Laravel 10, PHP 8.2, MySQL 8
- **Frontend**: React / Next.js 15, TailwindCSS
- **Contenedores**: Docker + Docker Compose

## 📁 Estructura del Proyecto

```
prueba-tareas/
│
├── backend-prueba-tareas/    # Backend (Laravel)
├── frontend-prueba-tareas/   # Frontend (Next.js)
├── .env.docker               # Variables de entorno para Docker
├── docker-compose.yml        # Configuración de servicios Docker
```

## ⚙️ Requisitos

- Docker y Docker Compose instalados (opcional si ejecutas sin contenedores)
- Node.js >= 18
- PHP >= 8.2
- Composer
- MySQL >= 8

## 🐳 Opción 1: Ejecutar con Docker (Puede verse mas lento las llamadas por el tema de la configuración del contenedor que esta hecha para desarrollo y no para un ambiente productivo)

1. Clona el repositorio:

```bash
git clone <repo-url>
cd prueba-tareas
```

2. Configura los entornos debes crear tanto .env.docker como .env, sigue como esta puesto en los example que deje

3. Levanta los contenedores:

```bash
docker-compose up --build
```

4. Accede a los contenedores y corre comandos:

```bash
docker exec -it laravel-backend bash
php artisan migrate
php artisan key:generate
php artisan jwt:secret
```

5. Accede a la app:

- **Frontend**: http://localhost:3000  
- **Backend API**: http://localhost:8000/api

## 💻 Opción 2: Ejecutar sin Docker

### Backend (Laravel)

1. Instala dependencias

```bash
cd backend-prueba-tareas
cp .env.example .env
composer install
```

2. Configura tu archivo `.env` con tu base de datos local y corre:

```bash
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan serve
```

### Frontend (Next.js)

1. Instala dependencias

```bash
cd frontend-prueba-tareas
npm install
```

2. Ejecuta el proyecto

```bash
npm run dev
```

## 🧪 Testing

- Backend: Laravel PHPUnit

```bash
php artisan test
```

## 📌 Notas

- Asegúrate de tener `.env.docker` correctamente configurado y que esas variables de bd coincidan con las de tu .env
- El puerto de MySQL está expuesto en `3307`, ajústalo si lo necesitas.
- La API usa JWT para autenticación.
