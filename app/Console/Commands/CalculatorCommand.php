<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculator {expression*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform basic calculations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expression = $this->argument('expression');
        $result = $this->calculate(explode(" ", $expression[0]));

        if ($result !== false) {
            $this->info('Result: '.$result);
        } else {
            $this->error('Invalid expression.');
        }
    }

    public function calculate($expression)
    {
        $numbers = [];
        $operator = '';

        foreach ($expression as $key => $expressionItem) {
            if (is_numeric($expressionItem)) {
                $numbers[] = $expressionItem;
            } elseif (in_array($expressionItem, ['+', '-', '*', '/'])) {
                if ($operator !== '') {
                    return false; // More than one operator encountered
                }
                $operator = $expressionItem;
            } elseif ($expressionItem === 'sqrt') {
                if(isset($expression[$key + 1]) && is_numeric($expression[$key + 1])) {
                    return sqrt($expression[$key + 1]);
                } else {
                    return "sqrt argument is not correct";
                }
            }
        }

        if (count($numbers) !== 2 || $operator === '') {
            return false; // Invalid expression
        }

        switch ($operator) {
            case '+':
                return $numbers[0] + $numbers[1];
            case '-':
                return $numbers[0] - $numbers[1];
            case '*':
                return $numbers[0] * $numbers[1];
            case '/':
                if ($numbers[1] == 0) {
                    return false; // Division by zero
                }
                return $numbers[0] / $numbers[1];
            default:
                return false;
        }
    }

}
