<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 08.02.18
 */

namespace service;

trait DatabaseTrait
{
    private static $db;

    public static function getDb()
    {
        return Database::getDb();
    }
}