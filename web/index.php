<?php

/**
 * Societo - Provides social site platform
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the LICENSE file that was distributed with this file.
 */

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('prod', false);
if (!empty($doctor)) {
    $kernel->enableDoctor();
}
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

try {
    $kernel->handle(Request::createFromGlobals())->send();
} catch (\Symfony\Component\Config\Exception\FileLoaderLoadException $e) {
    if (0 !== strpos($e->getMessage(), 'Cannot import resource "parameters.ini" from')) {
        throw $e;
    }

    echo 'Please create "app/config/parameters.ini" first. You just need to copy it from "app/config/default/parameters.ini".'.PHP_EOL;
} catch (\RuntimeException $e) {
    if (0 === strpos($e->getMessage(), 'Unable to create the cache directory') || 0 === strpos($e->getMessage(), 'Unable to write in the logs directory')) {
        exit($e->getMessage().'. Please make sure the permission of the directory is writable from web server.');
    }

    throw $e;
}
