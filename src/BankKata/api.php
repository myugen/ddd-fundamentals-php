<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LeanMind\BankKata\BankController;

// Simple entry point - no framework, no proper routing!
$controller = new BankController();
$controller->handleRequest();
