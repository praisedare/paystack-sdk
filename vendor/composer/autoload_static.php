<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf2afb729ec9f0bfac1de2aacebb80f6d
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Praise\\PaystackSdk\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Praise\\PaystackSdk\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf2afb729ec9f0bfac1de2aacebb80f6d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf2afb729ec9f0bfac1de2aacebb80f6d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf2afb729ec9f0bfac1de2aacebb80f6d::$classMap;

        }, null, ClassLoader::class);
    }
}
