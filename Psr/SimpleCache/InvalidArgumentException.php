<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.10.5
 * Time: 10.25
 */

namespace Psr\SimpleCache;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends CacheException
{
}