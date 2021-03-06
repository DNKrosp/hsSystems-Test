<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0a63bb4b730274496a4d3fd8b16a64f1
{
    public static $files = array (
        'c4764ba1afdbcfe4b0c6936fc6af2c04' => __DIR__ . '/../..' . '/paths.php',
    );

    public static $prefixLengthsPsr4 = array (
        'v' => 
        array (
            'view\\' => 5,
        ),
        'm' => 
        array (
            'model\\' => 6,
        ),
        'd' => 
        array (
            'database\\' => 9,
        ),
        'c' => 
        array (
            'controller\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'view\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/view',
        ),
        'model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/model',
        ),
        'database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/database',
        ),
        'controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/controller',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0a63bb4b730274496a4d3fd8b16a64f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0a63bb4b730274496a4d3fd8b16a64f1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0a63bb4b730274496a4d3fd8b16a64f1::$classMap;

        }, null, ClassLoader::class);
    }
}
