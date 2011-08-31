<?php

/**
 * Societo - Provides social site platform
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the LICENSE file that was distributed with this file.
 */

namespace Societo;

final class Version
{
    const VERSION = '0.5.0-dev1';

    public function __toString()
    {
        return self::VERSION;
    }
}
