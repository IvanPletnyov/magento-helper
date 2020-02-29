<?php

declare(strict_types=1);

namespace Framework\ModuleManager\Config;

/**
 * Module configuration file interface.
 */
interface ModuleConfigInterface
{
    /**
     * Array keys in module config cache.
     */
    public const KEY_MODULE_NAME = 'module_name';
    public const KEY_IS_MODULE_ENABLED = 'is_module_enabled';
    public const KEY_MODULE_DEPENDS = 'module_depends';
    public const KEY_MODULE_PATH = 'module_path';

    /**
     * Get module name in system.
     *
     * @return string
     */
    public function getModuleName(): string;

    /**
     * Is module enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Return list of modules this module depends on.
     *
     * @return array
     */
    public function getModuleDepends(): array;
}
