# 📦 Inventario MVC (PHP)

Sistema web de inventario construido con **PHP 8 y MySQL en PHP puro** (sin frameworks), aplicando el patrón **MVC** con arquitectura propia: front controller, enrutador, controladores, modelos con **PDO** y vistas.

> Proyecto 3 del portafolio para la postulación a **Practicante Backend – TEINOR S.A.C.**

## 🧰 Stack

- **PHP 8** (CLI) + servidor integrado
- **MySQL 8** con **PDO y sentencias preparadas** (previene SQL injection)
- **Patrón MVC** implementado desde cero: `Router`, `Controller`, `Models`, `Views`
- **Sesiones PHP** para autenticación
- **`password_hash()` / `password_verify()`** para contraseñas seguras
- **Tailwind CSS** (CDN) para la interfaz

## ✨ Funcionalidades

| Ruta | Descripción | Login |
|---|---|---|
| `/auth/login` | Iniciar sesión | No |
| `/` | Dashboard: totales + alerta de stock bajo | Sí |
| `/categories` | Listar categorías (con conteo de productos) | Sí |
| `/categories/form` · `/categories/edit/{id}` | Crear / editar categoría | Sí |
| `/products` | Listar productos (búsqueda + filtro stock bajo ≤ 5) | Sí |
| `/products/form` · `/products/edit/{id}` | Crear / editar producto | Sí |

Además:
- **CRUD completo** con validación de datos por controlador.
- **Borrado en cascada** vía llave foránea: eliminar una categoría borra sus productos.
- **Alertas visuales** de stock bajo (≤ 5 unidades) en el dashboard y la tabla.
- Mensajes *flash* (éxito/error) y **protección de rutas** por sesión.
- Todo el HTML se escapa con `htmlspecialchars()` (previene XSS).

## 🚀 Ponerla en marcha

```bash
# 1) Crear las bases en MySQL (usuario favio, clave eshop_pass)
sudo mysql -e "CREATE DATABASE IF NOT EXISTS inventario_db; CREATE DATABASE IF NOT EXISTS inventario_test_db; GRANT ALL PRIVILEGES ON inventario_db.* TO 'favio'@'localhost'; GRANT ALL PRIVILEGES ON inventario_test_db.* TO 'favio'@'localhost'; FLUSH PRIVILEGES;"

# 2) Instalar PHP
sudo apt-get install -y php-cli php-mysql php-mbstring

# 3) Crear tablas y datos de prueba
php database/seed.php

# 4) Levantar el servidor (el front controller recibe todas las rutas)
php -S localhost:8080 public/index.php
```

Abre **http://localhost:8080** y entra con el usuario demo:

| Email | Contraseña |
|---|---|
| `admin@tecnor.com` | `admin123` |

## 🧪 Pruebas

```bash
php tests/smoke_test.php   # 10 verificaciones: conexión, CRUD, cascada y stock bajo
```

## 📁 Estructura

```
inventario-mvc/
├── public/
│   ├── index.php          # Front controller: única puerta de entrada (todas las rutas)
│   └── .htaccess          # Reescritura para Apache
├── app/
│   ├── Core/              # Router, Controller base, Database (PDO)
│   ├── Controllers/       # Auth, Dashboard, Category, Product
│   ├── Models/            # Acceso a datos con sentencias preparadas
│   └── Views/             # Plantillas (layout, login, CRUD, 404)
├── config/config.php      # Conexión y BASE_URL (leíbles por variables de entorno)
├── database/              # schema.sql + seed.php (datos de prueba)
└── tests/smoke_test.php   # Prueba automatizada por CLI
```

## ❓ ¿Por qué PHP puro y no un framework?

Para el puesto lo importante es que se entienda **cómo funciona la web por dentro**: un framework como Laravel oculta el enrutamiento, las sesiones y PDO. Aquí cada pieza del MVC es código visible y didáctico, lo que demuestra base sólida antes de pasar a frameworks.

## 📜 Licencia

Proyecto educativo como parte del portafolio personal de **Favio Ordoñez Giribaldi**.