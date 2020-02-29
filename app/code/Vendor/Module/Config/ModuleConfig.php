<?php

declare(strict_types=1);

namespace Vendor\Module\Config;

use Framework\ModuleManager\Config\ModuleConfigInterface;

/**
 * @inheritDoc
 */
class ModuleConfig implements ModuleConfigInterface
{
    public const MODULE_NAME = 'Vendor_Module';

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
