<?php

/**
 * Societo - Provides social site platform
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the LICENSE file that was distributed with this file.
 */

require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\ApcUniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

if (ini_get('apc.enabled')) {
    $loader = new ApcUniversalClassLoader(md5(__FILE__));
} else {
    $loader = new UniversalClassLoader();
}

$loader->registerNamespaces(array(
    'Symfony'              => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Sensio'               => __DIR__.'/../vendor/bundles',
    'JMS'                  => __DIR__.'/../vendor/bundles',
    'Doctrine\\Common'     => __DIR__.'/../vendor/doctrine-common/lib',
    'Doctrine\\DBAL'       => __DIR__.'/../vendor/doctrine-dbal/lib',
    'Doctrine\\Tests\DBAL' => __DIR__.'/../vendor/doctrine-dbal/tests',
    'Doctrine'             => __DIR__.'/../vendor/doctrine/lib',
    'Monolog'              => __DIR__.'/../vendor/monolog/src',
    'Assetic'              => __DIR__.'/../vendor/assetic/src',
    'Metadata'             => __DIR__.'/../vendor/metadata/src',

    'Doctrine\\Common\\DataFixtures' => __DIR__.'/../vendor/doctrine-fixtures/lib',
    'WhiteOctober\PagerfantaBundle'  => __DIR__.'/../vendor/bundles',
    'Pagerfanta'                     => __DIR__.'/../vendor/pagerfanta/src',
    'Imagine'                        => __DIR__.'/../vendor/imagine/lib',

    'Societo' => __DIR__.'/../src',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_' => __DIR__.'/../vendor/twig-extensions/lib',
    'Twig_'            => __DIR__.'/../vendor/twig/lib',
));

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array(__DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile(__DIR__.'/../vendor/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once __DIR__.'/../vendor/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload(__DIR__.'/../vendor/swiftmailer/lib/swift_init.php');

$pear = __DIR__.'/../vendor/PEAR';
set_include_path($pear.PATH_SEPARATOR.get_include_path());
