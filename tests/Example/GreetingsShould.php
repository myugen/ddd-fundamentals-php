<?php

namespace LeanMind\Tests\Example;

use LeanMind\Example\Greetings;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GreetingsShould extends TestCase
{
    #[Test] public function says_hello_to_user()
    {
        $greetings = new Greetings('John');

        $this->assertEquals('Hello, John!', $greetings->sayHello());
    }
}
