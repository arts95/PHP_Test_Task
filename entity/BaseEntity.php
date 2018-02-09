<?php
/**
 * Created by PhpStorm.
 * User: arsenii
 * Date: 08.02.18
 * Time: 19:37
 */

namespace entity;


abstract class BaseEntity
{
    /**
     * @var array
     */
    protected $errors = [];

    abstract public static function getTableName(): string;

    abstract public static function getPrimaryKey(): string;

    abstract public function load(array $data): bool;

    public function validate(): bool
    {
        foreach ($this->gerRules() as $rule) {
            if (isset($rule['attribute']) && is_string($rule['attribute'])) {
                $this->prepareValidate($rule['attribute'], $rule);
            } elseif ($rule['attributes']) {
                foreach ($rule['attributes'] as $attribute) {
                    $this->prepareValidate($attribute, $rule);
                }
            }
        }
        return empty($this->errors);
    }

    abstract public function gerRules(): array;

    private function prepareValidate(string $attributeName, array $rule): void
    {
        $validator = $rule['validator'];
        /** @var ValidatorInterface $validator */
        $validator = new $validator($rule['options'] ?? null);
        if (!$validator->validate($this->$attributeName)) {
            $errors = $validator->getErrors();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->errors[$attributeName][] = $error;
                }
            }
        }
    }

    abstract public function getAttributes(): array;

    public function gerErrors(): array
    {
        return $this->errors;
    }

}