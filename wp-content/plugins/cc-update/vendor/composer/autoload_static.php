<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit462da04cfc56702e3ebc08de935ca068
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Clearcode\\Framework\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Clearcode\\Framework\\' => 
        array (
            0 => __DIR__ . '/..' . '/clearcode/wordpress-framework/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit462da04cfc56702e3ebc08de935ca068::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit462da04cfc56702e3ebc08de935ca068::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
