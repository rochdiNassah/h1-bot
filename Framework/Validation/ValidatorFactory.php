<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;

class ValidatorFactory
{
    public function __construct(
        private Application $app
    ) {

    }

    public function make(string $input_name, mixed $input): Validator
    {
        return app(Validator::class, [$input_name, $input]);
    }

    public function getErrors()
    {
        $errors = [];

        foreach ($this->app->getInstancesOf(Validator::class) as $instance) {
            $errors[] = $instance->getErrors();
        }

        return call_user_func_array('array_merge_recursive', $errors);
    }
}