<?php

declare(strict_types=1);

namespace Framework\PreferenceManager\Service;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\ModuleManager\Service\GetPrioritizedModulesPaths;
use Framework\PreferenceManager\Config\PreferencesConfigInterface;
use Framework\PreferenceManager\Exceptions\PreferenceConfigImplementationException;

/**
 * Find type by preference.
 */
class GetTypeByPreference
{
    private const PREFERENCES_CACHE_DIR_PATH = DS . 'var' . DS . 'cache' . DS . 'preferences' . DS . 'config';
    public const PREFERENCES_CACHE_FILE_PATH = self::PREFERENCES_CACHE_DIR_PATH . DS . 'data.helperconfig';

    /**
     * @var string[]
     */
    private $preferences = [];

    /**
     * @var GetPrioritizedModulesPaths
     */
    private $getPrioritizedModulesPaths;

    /**
     * @param GetPrioritizedModulesPaths $getPrioritizedModulesPaths
     */
    public function __construct(
        GetPrioritizedModulesPaths $getPrioritizedModulesPaths
    ) {
        $this->getPrioritizedModulesPaths = $getPrioritizedModulesPaths;
    }

    /**
     * @param string $type
     * @return string
     * @throws ConfigImplementationException
     */
    public function execute(string $type): string
    {
        if (empty($this->preferences)) {
            $this->preferences = $this->loadPreferences();
        }

        return $this->preferences[$type] ?? $type;
    }

    /**
     * Load preferences from cache. If cache is empty
     * it will load all preferences config from modules.
     *
     * @return array
     * @throws ConfigImplementationException
     */
    private function loadPreferences(): array
    {
        $this->preferences = $this->loadPreferenceCache();

        if (empty($this->preferences)) {
            foreach ($this->getPrioritizedModulesPaths->execute() as $modulePath) {
                $preferenceConfigFile = $modulePath . DS . 'Config' . DS . 'PreferencesConfig.php';
                if (is_file($preferenceConfigFile)) {
                    /** @var PreferencesConfigInterface $preferenceConfigData */
                    $preferenceConfigData = require_once $preferenceConfigFile;
                    if (!$preferenceConfigData instanceof PreferencesConfigInterface) {
                        throw new PreferenceConfigImplementationException(get_class($preferenceConfigData));
                    }

                    $this->preferences = array_replace_recursive(
                        $this->preferences,
                        $preferenceConfigData->getPreferences()
                    );
                }
            }
            $this->savePreferenceCache($this->preferences);
        }

        return $this->preferences;
    }

    /**
     * Load preference cache from var dir.
     *
     * @return array
     * @return void
     */
    private function loadPreferenceCache(): array
    {
        $result = [];
        $cacheFilePath = PD . self::PREFERENCES_CACHE_FILE_PATH;
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
    private function savePreferenceCache(array $preferencesData): void
    {
        if (!is_dir(PD . self::PREFERENCES_CACHE_DIR_PATH)) {
            createDir(PD . self::PREFERENCES_CACHE_DIR_PATH);
        }
        file_put_contents(PD . self::PREFERENCES_CACHE_FILE_PATH, serialize($preferencesData));
    }
}
