# GameZone E-commerce 🎮

### Plataforma de comercio electrónico para videojuegos y hardware

GameZone E-commerce es una aplicación web desarrollada principalmente en **PHP**, diseñada como una tienda digital especializada en videojuegos, consolas, accesorios y componentes relacionados con el gaming.

El sistema incorpora una base de datos SQL y diferentes niveles de acceso para clientes y administradores.

---

## 🎮 Sobre el proyecto

GameZone fue desarrollado para aplicar conceptos de comercio electrónico mediante la construcción de una plataforma capaz de organizar y presentar diferentes categorías de productos relacionados con videojuegos.

Los usuarios pueden explorar productos pertenecientes a diferentes áreas del ecosistema gaming.

---

## 🛒 Catálogo

La plataforma permite trabajar con diferentes tipos de productos, entre ellos:

### 🎮 Videojuegos

Catálogo de títulos disponibles para diferentes plataformas.

### 🕹️ Consolas

Productos relacionados con diferentes sistemas de videojuegos.

### 🎛️ Controles y accesorios

Accesorios pertenecientes a plataformas como:

- PlayStation
- Xbox
- Nintendo

### 💻 Componentes

También se contemplan productos y componentes electrónicos relacionados con el hardware, incluyendo diferentes elementos internos utilizados por los sistemas.

---

## 👤 Tipos de usuario

GameZone implementa diferentes niveles de acceso dependiendo del usuario.

### Cliente

Los clientes pueden acceder a las funcionalidades destinadas a la exploración de la tienda y sus productos.

### Administrador

Los administradores disponen de permisos y accesos diferentes a los usuarios convencionales para realizar tareas relacionadas con la administración de la plataforma.

Esta separación permite aplicar conceptos de:

- Autenticación.
- Roles.
- Permisos.
- Control de acceso.

---

## 🗄️ Base de datos

La aplicación utiliza una base de datos SQL para almacenar y gestionar la información necesaria para el funcionamiento de la plataforma.

Durante el desarrollo se utilizó un entorno PHP local y una herramienta de administración de bases de datos para gestionar la información del sistema.

---

## 🛠️ Tecnologías utilizadas

### Backend

- PHP
- SQL

### Frontend

- HTML
- CSS
- JavaScript

### Base de datos

- Base de datos relacional SQL
- Administración local de la base de datos

### Herramientas y conceptos

- Desarrollo web
- Comercio electrónico
- CRUD
- Autenticación
- Roles y permisos
- Gestión de productos
- Bases de datos relacionales
- Git
- GitHub

---

## 🏗️ Arquitectura general

```text
                   GAMEZONE
                       │
                       ▼
                 Aplicación Web
                       │
              ┌────────┴────────┐
              ▼                 ▼
           Cliente        Administrador
              │                 │
              ▼                 ▼
          Catálogo          Gestión
              │                 │
              └────────┬────────┘
                       ▼
                      PHP
                       │
                       ▼
                  Base de datos
                       │
                       ▼
                      SQL
