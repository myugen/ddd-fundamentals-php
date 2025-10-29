<?php

namespace LeanMind\BankKata;

use PDO;
use DateTime;

class Account
{
    private PDO $db;
    private string $accountId;

    public function __construct(string $accountId)
    {
        $this->accountId = $accountId;

        $this->db = new PDO(
            'mysql:host=localhost;dbname=bank_kata',
            'root',
            'password'
        );

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS transactions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                account_id VARCHAR(255) NOT NULL,
                amount DECIMAL(10, 2) NOT NULL,
                balance DECIMAL(10, 2) NOT NULL,
                date DATETIME NOT NULL,
                type VARCHAR(50) NOT NULL
            )
        ");
    }

    public function deposit(float $amount): void
    {
        $date = new DateTime();

        $currentBalance = $this->getCurrentBalance();
        $newBalance = $currentBalance + $amount;

        $stmt = $this->db->prepare("
            INSERT INTO transactions (account_id, amount, balance, date, type)
            VALUES (:account_id, :amount, :balance, :date, :type)
        ");

        $stmt->execute([
            'account_id' => $this->accountId,
            'amount' => $amount,
            'balance' => $newBalance,
            'date' => $date->format('Y-m-d H:i:s'),
            'type' => 'DEPOSIT'
        ]);

        echo "Deposited: $amount. New balance: $newBalance\n";
    }

    public function withdraw(float $amount): void
    {
        $date = new DateTime();

        $currentBalance = $this->getCurrentBalance();
        $newBalance = $currentBalance - $amount;

        $stmt = $this->db->prepare("
            INSERT INTO transactions (account_id, amount, balance, date, type)
            VALUES (:account_id, :amount, :balance, :date, :type)
        ");

        $stmt->execute([
            'account_id' => $this->accountId,
            'amount' => -$amount,
            'balance' => $newBalance,
            'date' => $date->format('Y-m-d H:i:s'),
            'type' => 'WITHDRAWAL'
        ]);

        echo "Withdrawn: $amount. New balance: $newBalance\n";
    }

    public function printStatement(): void
    {
        $stmt = $this->db->prepare("
            SELECT * FROM transactions
            WHERE account_id = :account_id
            ORDER BY date DESC
        ");

        $stmt->execute(['account_id' => $this->accountId]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "DATE       | AMOUNT  | BALANCE\n";
        echo "-----------------------------------\n";

        foreach ($transactions as $transaction) {
            $date = new DateTime($transaction['date']);
            $formattedDate = $date->format('d/m/Y');
            $amount = number_format($transaction['amount'], 2);
            $balance = number_format($transaction['balance'], 2);

            echo "$formattedDate | $amount | $balance\n";
        }
    }

    private function getCurrentBalance(): float
    {
        $stmt = $this->db->prepare("
            SELECT balance FROM transactions
            WHERE account_id = :account_id
            ORDER BY date DESC
            LIMIT 1
        ");

        $stmt->execute(['account_id' => $this->accountId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (float)$result['balance'] : 0.0;
    }

    public function getBalance(): float
    {
        return $this->getCurrentBalance();
    }
}
