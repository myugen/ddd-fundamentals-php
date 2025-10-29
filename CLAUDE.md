# DDD Fundamentals PHP - Project Overview

## Project Summary

This is a PHP educational project demonstrating Domain-Driven Design (DDD) fundamentals. It contains multiple Katas (coding exercises) that showcase both good practices and intentional anti-patterns for learning purposes.

**Tech Stack:**
- PHP 8.4
- PHPUnit 12.2 (testing framework)
- Mockery 1.6 (mocking library)
- MySQL 8.0 (for BankKata)
- Docker & Docker Compose
- Composer (dependency management)

---

## Commonly Used Commands

### Build & Setup
```bash
# Install PHP dependencies
composer install

# Build and run Docker environment
docker-compose build
```

### Testing
```bash
# Run all tests with verbose output
composer test

# Run tests with code coverage report (generates HTML)
composer test:coverage

# Run tests via Docker (recommended)
make test

# Run specific test file
./vendor/bin/phpunit tests/Example/GreetingsShould.php

# Run tests with watch (requires additional tools)
docker-compose run --build test
```

### Running Applications

#### BankKata Application
```bash
# Via Docker (recommended - includes MySQL)
docker-compose up bank-kata

# Via local PHP server (requires MySQL running locally)
php -S localhost:8000 -t src/BankKata

# Run example directly
php src/BankKata/example.php
```

The BankKata API will be available at `http://localhost:8000`

#### Test HTTP Requests
```bash
# Deposit money
curl -X POST http://localhost:8000/api.php/account/deposit \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 100.00}'

# Withdraw money
curl -X POST http://localhost:8000/api.php/account/withdraw \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 50.00}'

# Get balance
curl http://localhost:8000/api.php/account/balance?accountId=user123

# Get statement
curl http://localhost:8000/api.php/account/statement?accountId=user123
```

### Docker Management
```bash
# Start services (detached mode)
docker-compose up -d

# Stop all services
docker-compose down

# Stop and remove database volumes
docker-compose down -v

# View logs
docker-compose logs -f bank-kata
docker-compose logs -f mysql
```

---

## High-Level Architecture & Project Structure

### Directory Organization

```
ddd-fundamentals-php/
├── src/                          # Main application code
│   ├── Example/                  # Simple example demonstrating good practices
│   │   └── Greetings.php        # Basic class example
│   ├── BankKata/                 # Banking application kata (intentional anti-patterns)
│   │   ├── Account.php          # Monolithic class with mixed concerns
│   │   ├── BankController.php   # Request handler with poor separation
│   │   ├── api.php              # API entry point
│   │   ├── example.php          # Standalone usage example
│   │   ├── setup.sql            # Database initialization script
│   │   └── README.md            # BankKata documentation
│   └── MarsRover/                # Mars Rover kata (in planning/development)
│       └── README.md            # Requirements specification
├── tests/                        # Test suite
│   └── Example/
│       └── GreetingsShould.php  # Unit tests for Example
├── vendor/                       # Composer dependencies (auto-generated)
├── composer.json                # PHP dependency configuration
├── composer.lock                # Locked versions of dependencies
├── phpunit.xml                  # PHPUnit test configuration
├── Dockerfile                   # Docker image definition
├── docker-compose.yml           # Multi-container orchestration
├── Makefile                     # Make targets for common tasks
└── .php-version                 # PHP version specification (8.4.8)
```

### Namespace Organization

The project uses PSR-4 autoloading:
- **Application code:** `LeanMind\` namespace maps to `src/` directory
- **Test code:** `LeanMind\Tests\` namespace maps to `tests/` directory

### Project Components

#### 1. Example Module (`src/Example/`)
**Purpose:** Demonstrates basic, clean coding practices.

**Components:**
- `Greetings.php` - Simple class with single responsibility
- Test: `tests/Example/GreetingsShould.php` - Shows PHPUnit 12 attribute-based testing

**Architecture Pattern:** Straightforward OOP - good practice reference

---

#### 2. BankKata Module (`src/BankKata/`)
**Purpose:** Intentionally demonstrates anti-patterns and code smells for educational purposes.

**Components:**
- `Account.php` - Central class violating multiple SOLID principles:
  - Handles database connections directly (PDO instantiation in constructor)
  - Mixes business logic with data access
  - Uses hardcoded credentials
  - Creates DateTime instances directly without abstraction
  - Couples to console output (echo statements)
  - No dependency injection
  - Multiple responsibilities: persistence, transactions, output formatting

- `BankController.php` - Request handler with poor separation of concerns:
  - Directly accesses superglobals ($_SERVER, $_GET, php://input)
  - Instantiates Account directly
  - Mixes HTTP routing with business logic
  - Minimal error handling

- `api.php` - Bootstrap file that routes requests to BankController

- `example.php` - Demonstration script showing direct usage

- `setup.sql` - Database schema for BankKata

**Database Architecture:**
- Single table: `transactions`
- Stores all financial transactions with running balances
- Accessed directly via PDO without abstraction layer
- No separation between read and write models

**API Endpoints:**
- `POST /account/deposit` - Record deposit
- `POST /account/withdraw` - Record withdrawal  
- `GET /account/balance` - Get current balance
- `GET /account/statement` - Get transaction history

---

#### 3. MarsRover Module (`src/MarsRover/`)
**Status:** In planning/requirements definition phase

**Purpose:** Kata for implementing a rover positioning and movement system.

**Requirements:**
- Navigate rovers on a rectangular Martian plateau using coordinates (x, y) and cardinal direction
- Process movement commands: L (turn left), R (turn right), M (move forward)
- Sequentially execute commands for multiple rovers
- Return final position and orientation

---

### Testing Architecture

**Framework:** PHPUnit 12.2
**Style:** Modern attribute-based test methods (PHP 8 attributes)

**Test Features:**
- Located in `tests/` directory with same PSR-4 structure as src
- Uses `@[Test]` attributes instead of test* method prefixes
- Mockery integration available for creating test doubles
- Configuration in `phpunit.xml`:
  - Bootstrap via `vendor/autoload.php`
  - Autodiscovery of test files
  - Color output enabled by default

**Coverage:**
- Currently minimal (only Example module has tests)
- Can generate HTML coverage reports via `composer test:coverage`
- Reports saved to `coverage/` directory

---

### Dependency Management

**Key Dependencies:**
- `ext-pdo` - PHP Database Objects (required)
- `ext-pdo_mysql` - MySQL driver for PDO (required)

**Development Dependencies:**
- `phpunit/phpunit: ^12.2` - Testing framework
- `mockery/mockery: ^1.6` - Test doubles and mocking

**Autoloading:**
- PSR-4 standard
- Composer handles dependency resolution and autoloading

---

### Docker Architecture

**Multi-Service Setup:**

1. **test service**
   - Builds from provided Dockerfile
   - Runs PHPUnit tests
   - Isolated test environment

2. **bank-kata service**
   - PHP 8.4 CLI with Apache
   - Runs built-in PHP server on port 8000
   - Environment variables for database configuration:
     - `DB_HOST: mysql`
     - `DB_NAME: bank_kata`
     - `DB_USER: root`
     - `DB_PASSWORD: secret`

3. **mysql service**
   - MySQL 8.0 database
   - Auto-initializes with `setup.sql`
   - Persistent volume for data (`mysql_data`)
   - Port 3306 exposed for local access

**Dockerfile Features:**
- Based on PHP 8.4 with Apache
- Installs required PHP extensions (PDO, MySQL, ZIP, etc.)
- Installs Composer globally
- Optimizes autoloader on install

---

## Key Design Patterns & Concepts

### Anti-Patterns (Intentionally Demonstrated)
1. **Mixed Concerns** - Database, business logic, and presentation in one class
2. **Hard Dependencies** - Direct class instantiation without interfaces
3. **Tight Coupling** - Classes depend on concrete implementations
4. **Hidden Dependencies** - Dependencies created inside constructors
5. **Global State Access** - Direct superglobal access ($_SERVER, $_GET)
6. **No Abstraction** - Direct use of PDO, DateTime, echo without wrappers
7. **Procedural in OOP** - Logic mixed into controllers

### SOLID Violations (Educational Purposes)
- **SRP** - Account class has multiple reasons to change
- **OCP** - Hard to extend without modifying existing code
- **LSP** - No abstractions to substitute
- **ISP** - No interface segregation
- **DIP** - Depends on concrete implementations, not abstractions

---

## Configuration & Environment

**PHP Version:** 8.4.8 (defined in `.php-version`)

**Local Development Setup:**
1. Install Composer dependencies: `composer install`
2. Start MySQL locally with correct credentials
3. Run tests: `composer test`
4. Run BankKata: `php -S localhost:8000 -t src/BankKata`

**Docker Setup (Recommended):**
1. Install Docker and Docker Compose
2. Run tests: `make test`
3. Run application: `docker-compose up bank-kata`
4. Database auto-initializes from `src/BankKata/setup.sql`

---

## Development Workflow

1. **Write tests** in `tests/` directory following PSR-4 naming
2. **Implement code** in `src/` directory
3. **Run tests locally:** `composer test`
4. **Run in Docker:** `docker-compose run --build test`
5. **Test applications** with curl or in browser

**Git Considerations:**
- Ignores: `vendor/`, `.phpunit.result.cache`, `.idea/`
- All source files committed
- Composer.lock committed for reproducible builds

---

## Next Steps / Extensions

The MarsRover kata is set up for implementation. It demonstrates:
- Problem-driven development
- Incremental implementation from specifications
- Test-driven design patterns

Additional katas could be added following the same structure:
1. Create new directory in `src/`
2. Add README with requirements
3. Create test directory in `tests/`
4. Follow PSR-4 autoloading conventions
