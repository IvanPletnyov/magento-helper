<?php

declare(strict_types=1);

namespace Framework\ModuleManager\Service;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\ModuleManager\Config\ModuleConfigInterface;
use Framework\ModuleManager\Exceptions\ModuleConfigImplementationException;

/**
 * Return all modules configuration.
 */
class GetModulesConfig
{
    private const MODULES_CACHE_DIR_PATH = DS . 'var' . DS . 'cache' . DS . 'modules' . DS . 'config';
    public const MODULES_CACHE_FILE_PATH = self::MODULES_CACHE_DIR_PATH . DS . 'data.helperconfig';

    /**
     * @var array
     */
    private $modulesConfig = [];

    /**
     * @return array
     * @throws ConfigImplementationException
     */
    public function execute(): array
    {
        if (empty($this->modulesConfig)) {
            $this->modulesConfig = $this->loadModulesConfig();
        }

        return $this->modulesConfig;
    }

    /**
     * Load module config from cache. If cache is empty
     * it will load all module configs from modules.
     *
     * @return array
     * @throws ConfigImplementationException
     */
    private function loadModulesConfig(): array
    {
        $this->modulesConfig = $this->loadModulesConfigCache();

        if (empty($this->modulesConfig)) {
            foreach (DIRECTORIES_WITH_VENDORS as $vendorsDirectory) {
                if (is_dir($vendorsDirectory)) {
                    $modules = glob($vendorsDirectory . DS . '*' . DS . '*' . DS . 'Config' . DS . 'ModuleConfig.php');
                    foreach ($modules as $moduleConfigPath) {
                        /** @var ModuleConfigInterface $moduleConfigData */
                        $moduleConfigData = require_once $moduleConfigPath;
                        if (!$moduleConfigData instanceof ModuleConfigInterface) {
                            throw new ModuleConfigImplementationException(get_class($moduleConfigData));
                        }

                        if (false === $moduleConfigData->isEnabled()) {
                            continue;
                        }

                        $modulePath = $vendorsDirectory . DS . str_replace('_', DS, $moduleConfigData->getModuleName());
                        $this->modulesConfig[$moduleConfigData->getModuleName()] = [
                            ModuleConfigInterface::KEY_MODULE_NAME => $moduleConfigData->getModuleName(),
                            ModuleConfigInterface::KEY_IS_MODULE_ENABLED => $moduleConfigData->isEnabled(),
                            ModuleConfigInterface::KEY_MODULE_DEPENDS => $moduleConfigData->getModuleDepends(),
                            ModuleConfigInterface::KEY_MODULE_PATH => $modulePath,
                        ];
                    }
                }
            }
            $this->saveModulesConfigCache($this->modulesConfig);
        }

        return $this->modulesConfig;
    }

    /**
     * Load preference cache from var dir.
     *
     * @return array
     * @return void
     */
    private function loadModulesConfigCache(): array
    {
        $result = [];
        $cacheFilePath = PD . self::MODULES_CACHE_FILE_PATH;
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
    private function saveModulesConfigCache(array $preferencesData): void
    {
        if (!is_dir(PD . self::MODULES_CACHE_DIR_PATH)) {
            createDir(PD . self::MODULES_CACHE_DIR_PATH);
        }
        file_put_contents(PD . self::MODULES_CACHE_FILE_PATH, serialize($preferencesData));
    }
}
