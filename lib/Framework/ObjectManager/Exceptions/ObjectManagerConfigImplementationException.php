<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Exceptions;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\ObjectManager\Config\ObjectManagerConfigInterface;

/**
 * Object manager config must be implement \Framework\ObjectManager\Config\ObjectManagerConfigInterface exception.
 */
class ObjectManagerConfigImplementationException extends ConfigImplementationException
{
    /**
     * @var string
     */
    protected $configTitle = 'Object manager config';

    /**
     * @var string
     */
    protected $mustImplementInterfaceName = ObjectManagerConfigInterface::class;
}
