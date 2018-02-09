<?php
/**
 * Created by PhpStorm.
 * User: arsenii
 * Date: 08.02.18
 * Time: 19:50
 */

namespace validator;

class LengthValidator implements ValidatorInterface
{

    /**
     * @var int
     */
    public $maxLength;
    /**
     * @var int
     */
    public $minLength;
    /**
     * @var string
     */
    public $minLengthMessage;
    /**
     * @var string
     */
    public $maxLengthMessage;
    /**
     * @var string
     */
    public $typeMessage;
    /**
     * @var array
     */
    public $errors = [];

    public function __construct($options)
    {
        $this->maxLength = $options['max'];
        $this->minLength = $options['min'];
        $this->minLengthMessage = "Too short. Minimum: {$this->minLength}.";
        $this->maxLengthMessage = "Too long. Maximum: {$this->maxLength}.";
        $this->typeMessage = "String is required";
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        if ($errors = $this->validateValue($value)) {
            $this->errors[] = $errors;
            return empty($this->errors);
        }
        return true;
    }

    /**
     * @param string $value
     * @return null|string
     */
    protected function validateValue($value)
    {
        if (!is_string($value)) {
            return $this->typeMessage;
        }

        $length = mb_strlen($value);

        if ($this->minLength !== null && $length < $this->minLength) {
            return $this->minLengthMessage;
        }
        if ($this->maxLength !== null && $length > $this->maxLength) {
            return $this->maxLengthMessage;
        }

        return null;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}