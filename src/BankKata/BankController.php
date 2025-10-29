<?php

namespace LeanMind\BankKata;

use Exception;

class BankController
{
    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? '/';

        header('Content-Type: application/json');

        try {
            if ($path === '/account/deposit' && $method === 'POST') {
                $this->deposit();
            } elseif ($path === '/account/withdraw' && $method === 'POST') {
                $this->withdraw();
            } elseif ($path === '/account/statement' && $method === 'GET') {
                $this->statement();
            } elseif ($path === '/account/balance' && $method === 'GET') {
                $this->balance();
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not found', 'path' => $path]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function deposit(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $accountId = $input['accountId'] ?? 'default';
        $amount = (float)($input['amount'] ?? 0);

        $account = new Account($accountId);
        $account->deposit($amount);

        echo json_encode([
            'message' => 'Deposit successful',
            'balance' => $account->getBalance()
        ]);
    }

    private function withdraw(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $accountId = $input['accountId'] ?? 'default';
        $amount = (float)($input['amount'] ?? 0);

        $account = new Account($accountId);
        $account->withdraw($amount);

        echo json_encode([
            'message' => 'Withdrawal successful',
            'balance' => $account->getBalance()
        ]);
    }

    private function statement(): void
    {
        $accountId = $_GET['accountId'] ?? 'default';

        $account = new Account($accountId);

        ob_start();
        $account->printStatement();
        $statement = ob_get_clean();

        echo json_encode([
            'statement' => $statement
        ]);
    }

    private function balance(): void
    {
        $accountId = $_GET['accountId'] ?? 'default';

        $account = new Account($accountId);

        echo json_encode([
            'accountId' => $accountId,
            'balance' => $account->getBalance()
        ]);
    }
}
