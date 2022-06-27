<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;

class Validator
{
    private array $errors = [];

    public function __construct(
        private string $input_name,
        private mixed $input,
        private Application $app
    ) {

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
            $message = sprintf('"%s" must be between %s to %s characters long.', $this->input_name, $min, $max);

            if (is_null($max)) {
                $message = sprintf('"%s" must be at least %s characters long.', $this->input_name, $min);
            }

            array_push($this->errors, $message);
        }

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}