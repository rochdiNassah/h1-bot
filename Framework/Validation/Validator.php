<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;
use Automation\Framework\Facades\DB;

class Validator
{
    private array $errors = [];

    private string $formatted_input_name;

    public function __construct(
        private $input,
        private string $input_name,
        private Application $app
    ) {
        $this->formatted_input_name = $this->formatInputName();
    }

    private function formatInputName(): string
    {
        $input_name_parts           = explode(' ', str_replace(['_', '-'], ' ', $this->input_name));
        $formatted_input_name_parts = array_map(function ($part) {
            return ucfirst($part);
        }, $input_name_parts);
        
        return implode(' ', $formatted_input_name_parts);
    }

    public function getInputName(): string
    {
        return $this->input_name;
    }

    public function __toString(): string
    {
        return $this->input;
    }

    public function required(): self
    {
        if (0 === strlen($this->input)) {
            $message = sprintf('"%s" is required!', $this->formatted_input_name);

            array_push($this->errors, $message);
        }

        return $this;
    }

    public function in(array $array): self
    {
        if (!in_array($this->input, $array)) {
            $message = sprintf('"%s" value in %s is not expected!', $this->input, $this->formatted_input_name);

            array_push($this->errors, $message);
        }

        return $this;
    }

    public function length(int $min, int $max ): self
    {
        if (strlen($this->input) < $min || strlen($this->input) > $max) {
            $message = sprintf('"%s" must be between %s to %s characters long.', $this->formatted_input_name, $min, $max);
            
            array_push($this->errors, $message);
        }

        return $this;
    }

    public function exists(string $table, string $column): self
    {
        $stmt = DB::prepare(sprintf('SELECT * FROM `%s` where `%s` = ?', $table, $column));

        $stmt->execute(array($this->input));

        if (!$stmt->fetch()) {
            $message = sprintf('%s "%s" does not exist.', $column, $this->input);

            array_push($this->errors, $message);
        }

        return $this;
    }

    public function missingFrom(string $table, string $column): self
    {
        $stmt = DB::prepare(sprintf('SELECT * FROM `%s` where `%s` = ?', $table, $column));

        $stmt->execute(array($this->input));

        if ($stmt->fetch()) {
            $message = sprintf('%s "%s" is already exists.', $column, $this->input);

            array_push($this->errors, $message);
        }

        return $this;
    }

    public function strtolower(): self
    {
        $this->input = strtolower($this->input);

        return $this;
    }

    public function getErrors(): array
    {
        return [$this->input_name => $this->errors];
    }

    public function getFirstError(): array|null
    {
        if (empty($this->errors)) {
            return null;
        }

        return [array_shift($this->errors)];
    }
}
