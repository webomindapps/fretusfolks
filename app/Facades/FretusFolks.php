<?php

namespace App\Facades;

class FretusFolks
{

    public static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        return (self::resolveFacade('FretusFolks'))->$method(...$arguments);
    }
}