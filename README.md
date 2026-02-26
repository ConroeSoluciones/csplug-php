# CSPlug PHP SDK

[![Minimum PHP Version](https://img.shields.io/badge/php-%E2%89%A5%208.1-8892BF.svg)](https://php.net/)

SDK PHP oficial para consumir los recursos de la API del servicio [CSPlug](https://csplug.csfacturacion.com).

## 📥 Instalación

Puedes instalar la librería vía Composer:

```bash
composer require csfacturacion/csplug-php
```

## 🛠 Requisitos

- PHP >= 8.1
- Extensiones de PHP requeridas por `symfony/http-client`

## 🚀 Uso Básico

Para hacer solicitudes a la API de CSPlug, necesitas inicializar el cliente `CsPlugClient` configurando tus credenciales de acceso (Usuario y Contraseña).

```php
use Csfacturacion\CsPlug\CsPlugClient;

$client = CsPlugClient::create([
    'base_uri'  => 'https://csplug.csfacturacion.com', // Opcional, URI por defecto
    'username'  => 'tu_usuario',
    'password'  => 'tu_password',
]);
```

## 📚 Recursos Disponibles

El cliente te da acceso a los diversos recursos disponibles de la API:

- **CFDI:** `$client->cfdi()`
- **Emisores Hijos:** `$client->emisoresHijos()`
- **Certificados:** `$client->certificados()`
- **Certificados Emisor Hijo:** `$client->certificadosEmisorHijo()`
- **Series:** `$client->series()`
- **Series Emisor Hijo:** `$client->seriesEmisorHijo()`
- **Plantillas:** `$client->plantillas()`

### 💡 Ejemplo de Uso en Recursos

```php
// Obtener una lista de CFDI's
$facturas = $client->cfdi()->list();

// Crear un CFDI
$cfdi = $client->cfdi()->create([
    // array con la estructura y detalles requeridos para el payload del CFDI
]);
```

## 🔧 Integración con Laravel

El paquete incluye soporte nativo y un Proveedor de Servicios (*ServiceProvider*) para Laravel.

Al instalar vía Composer, Laravel realiza el **Auto-Discovery** por lo que no necesitas registrar el Provider manualmente.

### Configuración (Variables de Entorno .env)

Si usas Laravel, puedes configurar las credenciales usando tu archivo `.env`:

```env
CSPLUG_BASE_URI=https://csplug.csfacturacion.com
CSPLUG_USERNAME=tu_usuario
CSPLUG_PASSWORD=tu_password
CSPLUG_SERVICE=CSP
CSPLUG_TIMEOUT=30
CSPLUG_CONNECT_TIMEOUT=10
CSPLUG_DEBUG=false
```

Puedes publicar el archivo de configuración en tu proyecto ejecutando:

```bash
php artisan vendor:publish --provider="Csfacturacion\CsPlug\Laravel\CsPlugServiceProvider"
```

### Uso del Facade en Laravel

Puedes invocar al cliente del SDK desde donde sea utilizando su Facade local `CsPlug`:

```php
use CsPlug;

// Utiliza CsPlug estáticamente tal como usarías un cliente
$emisores = CsPlug::emisoresHijos()->list();
```

## 📝 Contribuir

Si deseas contribuir, por ejemplo ejecutando tests y control de calidad (Lints):

```bash
composer install
composer test
```
Este proyecto cuenta con herramientas pre-configuradas para calidad de código (`phpcs`, `phpstan`, `psalm`, y `phpunit`).

## 📄 Licencia

Este proyecto está distribuido bajo los términos de la Licencia MIT.
