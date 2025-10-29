# Bank Kata

Esta es una implementación intencionadamente mala del Bank Kata para demostrar anti-patrones y code smells.

## Malas Prácticas Implementadas

1. **Sin Separación de Capas**: Todo está mezclado - acceso a base de datos, lógica de negocio y presentación
2. **Conexión Directa a Base de Datos**: PDO se instancia directamente en el constructor de la clase Account
3. **Credenciales Hardcodeadas**: Las credenciales de la base de datos están hardcodeadas en el código fuente
4. **Sin Inversión de Dependencias**: Uso directo de clases concretas (PDO, DateTime, echo) sin interfaces
5. **Uso de System.out**: Uso directo de `echo` para imprimir salida
6. **Uso Directo del Reloj**: `new DateTime()` se usa directamente sin abstracción
7. **Sin Inyección de Dependencias**: Todas las dependencias se crean dentro de las clases
8. **Estado Global**: El controlador accede a `$_SERVER`, `$_GET`, `php://input` directamente
9. **Sin Manejo de Errores**: Manejo de errores y validación mínima
10. **Responsabilidades Mezcladas**: Controlador, lógica de negocio y acceso a datos en un solo lugar

## Configuración

### Prerequisitos
- PHP 8.0 o superior
- Base de datos MySQL
- Composer

### Configuración de la Base de Datos

1. Iniciar el servidor MySQL
2. Actualizar las credenciales en `src/BankKata/Account.php` si es necesario (líneas 18-20)
3. La base de datos y la tabla se crearán automáticamente en el primer uso

Alternativamente, ejecuta el script de configuración:
```bash
mysql -u root -p < src/BankKata/setup.sql
```

### Instalación

```bash
composer install
```

## Ejecutar la API

Inicia el servidor integrado de PHP:

```bash
php -S localhost:8000 -t src/BankKata
```

## Endpoints de la API

### Depositar Dinero
```bash
curl -X POST http://localhost:8000/api.php/account/deposit \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 100.00}'
```

### Retirar Dinero
```bash
curl -X POST http://localhost:8000/api.php/account/withdraw \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 50.00}'
```

### Obtener Saldo
```bash
curl http://localhost:8000/api.php/account/balance?accountId=user123
```

### Obtener Estado de Cuenta
```bash
curl http://localhost:8000/api.php/account/statement?accountId=user123
```

## Uso Directo de PHP

También puedes usar la clase Account directamente:

```php
<?php
require_once 'vendor/autoload.php';

use LeanMind\BankKata\Account;

$account = new Account('user123');
$account->deposit(1000);
$account->withdraw(100);
$account->printStatement();
```

## Por Qué Esto Es Malo

Esta implementación viola muchos principios SOLID y buenas prácticas:

- **Principio de Responsabilidad Única**: Las clases tienen múltiples razones para cambiar
- **Principio Abierto/Cerrado**: Difícil de extender sin modificar el código existente
- **Principio de Sustitución de Liskov**: No hay abstracciones que sustituir
- **Principio de Segregación de Interfaces**: No hay interfaces en absoluto
- **Principio de Inversión de Dependencias**: Depende de implementaciones concretas

Este código es intencionadamente malo con fines educativos para demostrar qué NO hacer.
