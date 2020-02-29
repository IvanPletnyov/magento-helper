<?php

declare(strict_types=1);

namespace Framework\CommandManager\Config;

use Framework\ModuleManager\Config\ModuleConfigInterface;

/**
 * @inheritDoc
 */
class ModuleConfig implements ModuleConfigInterface
{
    public const MODULE_NAME = 'Framework_CommandExecute';

    /**
     * @inheritDoc
     */
    public function getModuleName(): string
    {
        return self::MODULE_NAME;
    }

    /**
     * @inheritDoc
     */
    public function isEnabled(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getModuleDepends(): array
    {
        return [];
    }
}

return new ModuleConfig();
