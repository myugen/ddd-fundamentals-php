-- Database setup script for Bank Kata

CREATE DATABASE IF NOT EXISTS bank_kata;

USE bank_kata;

-- The Account class will create the transactions table automatically
-- This file is just for reference and manual database creation if needed

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    balance DECIMAL(10, 2) NOT NULL,
    date DATETIME NOT NULL,
    type VARCHAR(50) NOT NULL,
    INDEX idx_account_id (account_id),
    INDEX idx_date (date)
);
