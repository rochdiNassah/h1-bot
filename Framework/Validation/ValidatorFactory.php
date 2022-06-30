<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;

class ValidatorFactory
{
    public function __construct(
        private Application $app
    ) {

    }

    public function make(string $input_name): Validator
    {
        return app(Validator::class, [$input_name]);
    }

    public function getErrors()
    {
        $errors = [];

        foreach ($this->app->getInstancesOf(Validator::class) as $instance) {
            $first_error = $instance->getFirstError();

            if (!is_null($first_error)) {
                $errors[] = $first_error;
            }
        }

        return call_user_func_array('array_merge_recursive', $errors);
    }
}