<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Application;
use Automation\Framework\Http\Request;

class ValidatorFactory
{
    public function __construct(
        private Request $request,
        private Application $app
    ) {

    }

    public function make(string $input_name): Validator
    {
        $input = '';

        if ($this->request->has($input_name)) {
            $input = $this->request->inputs($input_name);
        }

        return app(Validator::class, [$input, $input_name]);
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