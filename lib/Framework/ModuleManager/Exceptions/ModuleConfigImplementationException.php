<?php

declare(strict_types=1);

namespace Framework\ModuleManager\Exceptions;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\ModuleManager\Config\ModuleConfigInterface;

/**
 * Module config must be implement \Framework\ModuleManager\Config\ModuleConfigInterface exception.
 */
class ModuleConfigImplementationException extends ConfigImplementationException
{
    /**
     * @var string
     */
    protected $configTitle = 'Module config';

    /**
     * @var string
     */
    protected $mustImplementInterfaceName = ModuleConfigInterface::class;
}
