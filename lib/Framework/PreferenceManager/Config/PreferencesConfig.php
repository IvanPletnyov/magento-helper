<?php

declare(strict_types=1);

namespace Framework\PreferenceManager\Config;

/**
 * @inheritDoc
 */
class PreferencesConfig implements PreferencesConfigInterface
{
    /**
     * @inheritDoc
     */
    public function getPreferences(): array
    {
        return [];
    }
}

return new PreferencesConfig();
