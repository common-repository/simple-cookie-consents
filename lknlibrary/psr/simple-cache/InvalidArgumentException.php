<?php

namespace Psr\SimpleCache;

defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');


/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends CacheException
{
}
