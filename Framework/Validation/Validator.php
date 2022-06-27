<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;

class Validator
{
    private array $errors = [];

    private string $formatted_input_name;

    public function __construct(
        private string $input_name,
        private mixed $input,
        private Application $app
    ) {
        $this->formatted_input_name = implode(' ', array_map(function ($part) { return ucfirst($part); }, explode(' ', str_replace(['_', '-'], ' ', $input_name))));
    }

    public function getInputName(): string
    {
        return $this->input_name;
    }

    public function __toString(): string
    {
        return $this->input;
    }

    public function length(int $min, int $max = null)
    {
        if (strlen($this->input) < $min || (null !== $max && strlen($this->input) > $max)) {
            $message = sprintf('"%s" field must be between %s to %s characters long.', $this->formatted_input_name, $min, $max);

            if (is_null($max)) {
                $message = sprintf('"%s" field must be at least %s characters long.', $this->formatted_input_name, $min);
            }

            $this->errors[$this->input_name] = $message;
        }

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}