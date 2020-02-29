<?php

declare(strict_types=1);

namespace Framework\PreferenceManager\Config;

/**
 * Preferences configuration file interface.
 */
interface PreferencesConfigInterface
{
    /**
     * Return object preferences.
     *
     * @return string[]
     */
    public function getPreferences(): array;
}
