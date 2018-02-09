<?php
/**
 * Created by PhpStorm.
 * User: arsenii
 * Date: 08.02.18
 * Time: 20:20
 */

namespace validator;
interface ValidatorInterface
{
    public function validate($value): bool;

    public function getErrors(): array;
}