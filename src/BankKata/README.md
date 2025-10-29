# Bank Kata - Bad Practices Implementation

This is an intentionally bad implementation of the Bank Kata to demonstrate anti-patterns and code smells.

## Bad Practices Implemented

1. **No Separation of Layers**: Everything is mixed together - database access, business logic, and presentation
2. **Direct Database Connection**: PDO is instantiated directly in the Account class constructor
3. **Hardcoded Credentials**: Database credentials are hardcoded in the source code
4. **No Dependency Inversion**: Direct use of concrete classes (PDO, DateTime, echo) without interfaces
5. **System.out Usage**: Direct use of `echo` for printing output
6. **Direct Clock Usage**: `new DateTime()` is used directly without abstraction
7. **No Dependency Injection**: All dependencies are created inside the classes
8. **Global State**: Controller accesses `$_SERVER`, `$_GET`, `php://input` directly
9. **No Error Handling**: Minimal error handling and validation
10. **Mixed Responsibilities**: Controller, business logic, and data access all in one place

## Setup

### Prerequisites
- PHP 8.0 or higher
- MySQL database
- Composer

### Database Setup

1. Start MySQL server
2. Update credentials in `src/BankKata/Account.php` if needed (lines 18-20)
3. The database and table will be created automatically on first use

Alternatively, run the setup script:
```bash
mysql -u root -p < src/BankKata/setup.sql
```

### Installation

```bash
composer install
```

## Running the API

Start the PHP built-in server:

```bash
php -S localhost:8000 -t src/BankKata
```

## API Endpoints

### Deposit Money
```bash
curl -X POST http://localhost:8000/api.php/account/deposit \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 100.00}'
```

### Withdraw Money
```bash
curl -X POST http://localhost:8000/api.php/account/withdraw \
  -H "Content-Type: application/json" \
  -d '{"accountId": "user123", "amount": 50.00}'
```

### Get Balance
```bash
curl http://localhost:8000/api.php/account/balance?accountId=user123
```

### Get Statement
```bash
curl http://localhost:8000/api.php/account/statement?accountId=user123
```

## Direct PHP Usage

You can also use the Account class directly:

```php
<?php
require_once 'vendor/autoload.php';

use LeanMind\BankKata\Account;

$account = new Account('user123');
$account->deposit(1000);
$account->withdraw(100);
$account->printStatement();
```

## Why This Is Bad

This implementation violates many SOLID principles and best practices:

- **Single Responsibility Principle**: Classes have multiple reasons to change
- **Open/Closed Principle**: Hard to extend without modifying existing code
- **Liskov Substitution Principle**: No abstractions to substitute
- **Interface Segregation Principle**: No interfaces at all
- **Dependency Inversion Principle**: Depends on concrete implementations

This code is intentionally bad for educational purposes to demonstrate what NOT to do.
