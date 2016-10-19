<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb07750623e7e9bc6454b8810d3f8d21
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb07750623e7e9bc6454b8810d3f8d21::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb07750623e7e9bc6454b8810d3f8d21::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
