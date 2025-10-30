# DDD Fundamentals PHP

Proyecto educativo que demuestra los fundamentos de Domain-Driven Design (DDD) mediante ejercicios prácticos (Katas) en PHP.

## Descripción

Este repositorio contiene múltiples Katas que ilustran tanto buenas prácticas como anti-patrones intencionales con fines educativos. El objetivo es aprender a identificar y refactorizar código que viola los principios SOLID y las buenas prácticas de DDD.

## Stack Tecnológico

- **PHP 8.4**
- **PHPUnit 12.2** - Framework de testing
- **Mockery 1.6** - Librería de mocking
- **MySQL 8.0** - Base de datos (para BankKata)
- **Docker & Docker Compose** - Contenerización
- **Composer** - Gestión de dependencias

## Estructura del Proyecto

```
ddd-fundamentals-php/
├── src/
│   ├── Example/              # Ejemplo dummy de clase
│   ├── BankKata/             # Kata bancaria (con anti-patrones intencionales)
│   └── MarsRover/            # Kata Mars Rover (en desarrollo)
├── tests/                    # Suite de tests
├── docker-compose.yml        # Configuración de servicios Docker
├── Dockerfile                # Imagen Docker del proyecto
└── composer.json             # Dependencias PHP
```

### Módulos Disponibles

#### 1. Example (`src/Example/`)
Ejemplo simple de una clase con tests unitarios para demostrar la configuración del entorno de testing.

#### 2. BankKata (`src/BankKata/`)
Aplicación bancaria que **intencionalmente** demuestra anti-patrones y code smells:

- Mezcla de responsabilidades (persistencia, lógica de negocio, presentación)
- Acoplamiento fuerte a implementaciones concretas (PDO, DateTime)
- Falta de inyección de dependencias
- Acceso directo a variables globales
- Credenciales hardcodeadas

**Funcionalidad:**
- Realizar depósitos y retiros
- Consultar saldo
- Ver historial de transacciones

#### 3. MarsRover (`src/MarsRover/`)
Kata para implementar un sistema de navegación de rovers en Marte haciendo uso de DDD.

## Instalación y Configuración

### Requisitos Previos

- Docker y Docker Compose (recomendado)
- O bien: PHP 8.4, Composer, MySQL 8.0

### Opción 1: Con Docker (Recomendado)

1. **Clonar el repositorio:**
```bash
git clone git@github.com:myugen/ddd-fundamentals-php.git
cd ddd-fundamentals-php
```

2. **Construir e instalar dependencias:**
```bash
docker-compose build
```

3. **Listo para usar!**

### Opción 2: Instalación Local

1. **Instalar dependencias:**
```bash
composer install
```

2. **Configurar MySQL:**
   - Crear base de datos `bank_kata`
   - Usuario: `root`
   - Contraseña: `secret`
   - Ejecutar script: `src/BankKata/setup.sql`

## Uso

### Ejecutar Tests

```bash
# Con Composer
composer test

# Con cobertura de código (genera reporte HTML)
composer test:coverage

# Con Docker (recomendado)
make test

# Test específico
./vendor/bin/phpunit tests/Example/GreetingsShould.php
```

### Ejecutar BankKata

#### Con Docker:
```bash
docker-compose up bank-kata
```

La API estará disponible en `http://localhost:8000`

#### Sin Docker:
```bash
# Asegúrate de que MySQL está corriendo
php -S localhost:8000 -t src/BankKata
```

#### Ejecutar ejemplo standalone:
```bash
php src/BankKata/example.php
```

### Probar la API de BankKata

```bash
# Depositar dinero
curl -X POST http://localhost:8000/api.php/account/deposit \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 100.00}'

# Retirar dinero
curl -X POST http://localhost:8000/api.php/account/withdraw \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 50.00}'

# Consultar saldo
curl http://localhost:8000/api.php/account/balance?accountId=user123

# Ver extracto de movimientos
curl http://localhost:8000/api.php/account/statement?accountId=user123
```

### Gestión de Docker

```bash
# Iniciar servicios en segundo plano
docker-compose up -d

# Detener todos los servicios
docker-compose down

# Detener y eliminar volúmenes de base de datos
docker-compose down -v

# Ver logs
docker-compose logs -f bank-kata
docker-compose logs -f mysql
```

## Conceptos Educativos

### Anti-Patrones Demostrados (Intencionales)

El módulo BankKata **deliberadamente** incluye estos anti-patrones para fines educativos:

1. **Mezcla de Responsabilidades:** Una clase maneja base de datos, lógica de negocio y presentación
2. **Dependencias Ocultas:** Creación de dependencias dentro del constructor
3. **Acoplamiento Fuerte:** Dependencia directa de clases concretas (PDO, DateTime)
4. **Sin Abstracciones:** Uso directo de implementaciones sin interfaces
5. **Acceso a Estado Global:** Acceso directo a superglobales ($_SERVER, $_GET)
6. **Hardcodeo:** Credenciales de base de datos hardcodeadas
7. **Violaciones SOLID:** Múltiples violaciones de los principios SOLID

### Violaciones de Principios SOLID

- **SRP (Single Responsibility):** La clase Account tiene múltiples razones para cambiar
- **OCP (Open/Closed):** Difícil de extender sin modificar código existente
- **LSP (Liskov Substitution):** No hay abstracciones para sustituir
- **ISP (Interface Segregation):** No hay segregación de interfaces
- **DIP (Dependency Inversion):** Depende de implementaciones concretas, no abstracciones

### Objetivo Pedagógico

El propósito es que los estudiantes:
1. Identifiquen estos anti-patrones en el código
2. Comprendan por qué son problemáticos
3. Practiquen refactorización hacia código más limpio
4. Apliquen principios DDD y SOLID

## Testing

El proyecto utiliza PHPUnit 12 con atributos modernos de PHP 8:

```php
use PHPUnit\Framework\Attributes\Test;

class GreetingsShould extends TestCase
{
    #[Test]
    public function say_hello(): void
    {
        // Test implementation
    }
}
```

### Características de Testing:
- Tests organizados bajo `tests/` con estructura PSR-4
- Soporte para mocking con Mockery
- Generación de reportes de cobertura
- Salida con colores habilitada

## Comandos Útiles

```bash
# Instalación
composer install                    # Instalar dependencias PHP
docker-compose build               # Construir entorno Docker

# Testing
composer test                      # Ejecutar todos los tests
composer test:coverage            # Tests con reporte de cobertura
make test                         # Tests en Docker

# Ejecución
docker-compose up bank-kata       # Iniciar aplicación bancaria
php src/BankKata/example.php     # Ejecutar ejemplo standalone

# Docker
docker-compose up -d              # Iniciar servicios
docker-compose down               # Detener servicios
docker-compose logs -f            # Ver logs en tiempo real
```

## Arquitectura Docker

### Servicios:

1. **test:** Entorno aislado para ejecutar tests
2. **bank-kata:** Servidor PHP con la aplicación bancaria (puerto 8000)
3. **mysql:** Base de datos MySQL 8.0 con inicialización automática

### Variables de Entorno:

```yaml
DB_HOST: mysql
DB_NAME: bank_kata
DB_USER: root
DB_PASSWORD: secret
```

## Próximos Pasos

- Implementar MarsRover Kata
- Añadir más ejemplos de refactorización
- Crear ejercicios guiados paso a paso
- Expandir suite de tests

## Contribuir

Este es un proyecto educativo. Las contribuciones son bienvenidas, especialmente:
- Nuevas Katas
- Ejemplos adicionales de anti-patrones
- Mejoras en la documentación
- Ejercicios de refactorización guiados

## Licencia

Proyecto educativo de código abierto.

---

**Nota:** Los anti-patrones en BankKata son **intencionales** con fines educativos. No representan buenas prácticas de desarrollo.
