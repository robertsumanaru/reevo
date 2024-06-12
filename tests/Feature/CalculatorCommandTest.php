<?php

namespace Tests\Feature;

use App\Console\Commands\CalculatorCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculatorCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBasicAddition()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['5', '+', '3']);
        $this->assertEquals(8, $result);
    }

    public function testBasicSubtraction()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['10', '-', '5']);
        $this->assertEquals(5, $result);
    }

    public function testBasicMultiplication()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['2', '*', '3']);
        $this->assertEquals(6, $result);
    }

    public function testBasicDivision()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['10', '/', '2']);
        $this->assertEquals(5, $result);
    }

    public function testDivisionByZero()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['10', '/', '0']);
        $this->assertFalse($result);
    }

    public function testSquareRoot()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['sqrt', '25']);
        $this->assertEquals(5, $result);
    }

    public function testOnlyANumber()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['10']);
        $this->assertEquals(10,$result);
    }

    public function testInvalidSqrtUsage()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['sqrt', '25', '5']);
        $this->assertEquals(5,$result);
    }

    public function testMultipleOperators()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['5', '+', '3', '-', '2']);
        $this->assertEquals(6,$result);
    }

    public function testWithLetters()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['10', '+', 'a']);
        $this->assertEquals("Invalid expression. Only numbers, '+', '-', '*', '/', and 'sqrt' are allowed.",$result);
    }

    public function testSquareRootLetter()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['sqrt', 'a']);
        $this->assertEquals("sqrt argument is not correct", $result);
    }

    public function testSquareRootMissing()
    {
        $command = new CalculatorCommand();
        $result = $command->calculate(['sqrt', '']);
        $this->assertEquals("sqrt argument is not correct", $result);
    }
}
