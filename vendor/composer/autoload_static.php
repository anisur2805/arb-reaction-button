<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitffdc223a991d24d5f90be7ff360e4fa1
{
    public static $files = array (
        'e75dfec13454cac43905e7ab6c4afe7f' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'ARB\\Reaction_Button\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ARB\\Reaction_Button\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitffdc223a991d24d5f90be7ff360e4fa1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitffdc223a991d24d5f90be7ff360e4fa1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitffdc223a991d24d5f90be7ff360e4fa1::$classMap;

        }, null, ClassLoader::class);
    }
}
