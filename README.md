# Proyecto Tienda MVC - PHP + MySQL + Bootstrap

Proyecto didáctico para aprender CRUD utilizando el patrón Modelo-Vista-Controlador (MVC).

## Requisitos

- XAMPP
- Apache
- MySQL
- PHP 8.x
- Navegador web
- Visual Studio Code

## Instalación

1. Copiar la carpeta `tienda-mvc` dentro de:
   `C:\xampp\htdocs\`

2. Iniciar **Apache** y **MySQL** desde XAMPP.

3. Abrir phpMyAdmin:
   `http://localhost/phpmyadmin`

4. Crear/importar la base de datos ejecutando el archivo:
   `tienda.sql`

5. Abrir el proyecto:
   `http://localhost/tienda-mvc/public/`

## Estructura MVC

- `models/` → acceso a datos y lógica del modelo.
- `views/` → interfaz HTML + Bootstrap.
- `controllers/` → recibe las peticiones y coordina Modelo/Vista.
- `config/` → configuración de la conexión.
- `public/` → punto de entrada de la aplicación.

## CRUD

- Crear productos
- Listar productos
- Buscar productos
- Editar productos
- Eliminar productos

## Credenciales MySQL de XAMPP

Por defecto:

Usuario: `root`
Contraseña: vacía

Si su instalación utiliza otra contraseña, modificar:
`config/database.php`

## Actividad sugerida para estudiantes

1. Comprender el flujo Modelo → Controlador → Vista.
2. Cambiar el diseño de Bootstrap.
3. Agregar campo `marca`.
4. Crear tabla `categorias`.
5. Relacionar `productos` con `categorias`.
6. Agregar validaciones.
7. Crear CRUD de clientes.
8. Crear CRUD de proveedores.
9. Implementar un menú general del sistema.
