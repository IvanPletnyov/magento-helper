<?php

declare(strict_types=1);

namespace Vendor\Module\Config;

use Framework\PreferenceManager\Api\GetPreferenceCacheDirPathInterface;
use Framework\PreferenceManager\Config\PreferencesConfigInterface;

class PreferencesConfig implements PreferencesConfigInterface
{
    /**
     * @inheritDoc
     */
    public function getPreferences(): array
    {
        return [
            '54y4745uj65j6j5rj6r5j' => 'asdasdawdawdawdawd',
        ];
    }
}

return new PreferencesConfig();
