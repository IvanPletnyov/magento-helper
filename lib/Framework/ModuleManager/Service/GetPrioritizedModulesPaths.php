<?php

declare(strict_types=1);

namespace Framework\ModuleManager\Service;

use Framework\ModuleManager\Config\ModuleConfigInterface;

/**
 * Get modules paths sorted by modules sequence.
 */
class GetPrioritizedModulesPaths
{
    private const MODULES_PATHS_CACHE_DIR_PATH = DS . 'var' . DS . 'cache' . DS . 'modules' . DS . 'priority';
    public const MODULES_PATHS_CACHE_FILE_PATH = self::MODULES_PATHS_CACHE_DIR_PATH . DS . 'data.helperconfig';

    /**
     * @var GetModulesConfig
     */
    private $getModulesConfig;

    /**
     * @var string[]
     */
    private $prioritizedModulesPaths;

    /**
     * @param GetModulesConfig $getModulesConfig
     */
    public function __construct(
        GetModulesConfig $getModulesConfig
    ) {
        $this->getModulesConfig = $getModulesConfig;
    }

    /**
     * @return string[]
     */
    public function execute(): array
    {
        if (empty($this->prioritizedModulesPaths)) {
            $this->prioritizedModulesPaths = $this->loadModulesPathsCache();
            if (empty($this->prioritizedModulesPaths)) {
                $this->prioritizedModulesPaths = $this->sortModulesByDependency($this->getModulesConfig->execute());
            }
        }

        return $this->prioritizedModulesPaths;
    }

    /**
     * Load preference cache from var dir.
     *
     * @return array
     * @return void
     */
    private function loadModulesPathsCache(): array
    {
        $result = [];
        $cacheFilePath = PD . self::MODULES_PATHS_CACHE_FILE_PATH;
        if (is_file($cacheFilePath)) {
            $result = unserialize(file_get_contents($cacheFilePath));
        }

        return $result;
    }

    /**
     * Save preference cache to var dir.
     *
     * @param array $preferencesData
     * @return void
     */
    private function saveModulesPathsCache(array $preferencesData): void
    {
        if (!is_dir(PD . self::MODULES_PATHS_CACHE_DIR_PATH)) {
            createDir(PD . self::MODULES_PATHS_CACHE_DIR_PATH);
        }
        file_put_contents(PD . self::MODULES_PATHS_CACHE_FILE_PATH, serialize($preferencesData));
    }

    /**
     * Sort all modules by dependency.
     *
     * @param array $modulesConfig
     * @return array
     */
    private function sortModulesByDependency(array $modulesConfig): array
    {
        //TODO Доделать сортировку путей модулей по зависимостям модулей. Пока вывожу как есть.
        return array_column($modulesConfig, ModuleConfigInterface::KEY_MODULE_PATH);
    }
}
