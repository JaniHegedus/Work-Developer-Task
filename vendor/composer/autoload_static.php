<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03bd3224bde77a84064d27b71e34a756
{
    public static $files = array (
        '3033cdb011db5320c470cdf24a257181' => __DIR__ . '/../..' . '/Pages/Index.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit03bd3224bde77a84064d27b71e34a756::$classMap;

        }, null, ClassLoader::class);
    }
}
