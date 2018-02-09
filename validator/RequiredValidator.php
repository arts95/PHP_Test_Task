<?php
/**
 * Created by PhpStorm.
 * User: arsenii
 * Date: 08.02.18
 * Time: 20:40
 */

namespace validator;

class RequiredValidator implements ValidatorInterface
{
    protected $errors = [];

    public function validate($value): bool
    {
        if ($errors = $this->validateValue($value)) {
            $this->errors[] = $errors;
            return empty($this->errors);
        }
        return true;
    }

    protected function validateValue($value)
    {
        if ($value !== null && !$this->isEmpty(is_string($value) ? trim($value) : $value)) {
            return null;
        } else {
            return 'Field is required';
        }

    }

    public function isEmpty($value)
    {
        return $value === null || $value === [] || $value === '';
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}