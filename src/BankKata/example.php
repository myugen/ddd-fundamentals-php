<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LeanMind\BankKata\Account;

// Direct instantiation - no dependency injection!
echo "=== Bank Kata Example (Bad Practices) ===\n\n";

$account = new Account('john_doe');

echo "Making deposits...\n";
$account->deposit(1000.00);
$account->deposit(500.00);

echo "\nMaking withdrawals...\n";
$account->withdraw(200.00);

echo "\nPrinting statement...\n";
$account->printStatement();

echo "\nCurrent balance: " . $account->getBalance() . "\n";
