<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6d2d762ecfb9231cc8e81b269848f3b3
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rede\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rede\\' => 
        array (
            0 => __DIR__ . '/..' . '/developersrede/erede-php/src/Rede',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6d2d762ecfb9231cc8e81b269848f3b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6d2d762ecfb9231cc8e81b269848f3b3::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}