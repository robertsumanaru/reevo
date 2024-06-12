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
        $operators = [];

        foreach ($expression as  $key => $expressionItem) {
            if (is_numeric($expressionItem)) {
                $numbers[] = $expressionItem;
            } elseif (in_array($expressionItem, ['+', '-'])) {
                while (!empty($operators) && ($operators[count($operators) - 1] === '*' || $operators[count($operators) - 1] === '/')) {
                    $this->evaluateExpression($numbers, $operators);
                }
                $operators[] = $expressionItem;
            } elseif (in_array($expressionItem, ['*', '/'])) {
                $operators[] = $expressionItem;
            } elseif ($expressionItem === 'sqrt') {
                // Handle square root separately
                if (isset($expression[$key + 1]) && is_numeric($expression[$key + 1])) {
                    return sqrt($expression[$key + 1]);
                } else {
                    if(isset($expression[$key + 1]) && !is_numeric($expression[$key + 1])) {
                        return "sqrt argument is not correct";
                    }
                    return "sqrt argument is missing";
                }
            } else {
                return "Invalid expression. Only numbers, '+', '-', '*', '/', and 'sqrt' are allowed.";
            }
        }

        // Evaluate remaining expression
        while (!empty($operators)) {
            $this->evaluateExpression($numbers, $operators);
        }

        if (count($numbers) !== 1) {
            return false; // Invalid expression
        }

        return $numbers[0];
    }

    private function evaluateExpression(&$numbers, &$operators)
    {
        $operator = array_pop($operators);
        $operand2 = array_pop($numbers);
        $operand1 = array_pop($numbers);

        switch ($operator) {
            case '+':
                $result = $operand1 + $operand2;
                break;
            case '-':
                $result = $operand1 - $operand2;
                break;
            case '*':
                $result = $operand1 * $operand2;
                break;
            case '/':
                if ($operand2 == 0) {
                    return false; // Division by zero
                }
                $result = $operand1 / $operand2;
                break;
            default:
                return false;
        }

        $numbers[] = $result;
    }

}
