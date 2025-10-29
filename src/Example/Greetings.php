<?php

namespace LeanMind\Example;

class Greetings
{
    private string $to;

    public function __construct(string $to)
    {
        $this->to = $to;
    }

    public function sayHello(): string
    {
        return "Hello, $this->to!";
    }
}