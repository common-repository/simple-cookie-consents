<?php

namespace Psr\Cache;

defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');


/**
 * Exception interface for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements Psr\Cache\InvalidArgumentException.
 */
interface InvalidArgumentException extends CacheException
{
}
