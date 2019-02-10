<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit25fce18a68b73a958cbcbff590448e3c
{
    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\composer\\' => 15,
            'think\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-image/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit25fce18a68b73a958cbcbff590448e3c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit25fce18a68b73a958cbcbff590448e3c::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit25fce18a68b73a958cbcbff590448e3c::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}