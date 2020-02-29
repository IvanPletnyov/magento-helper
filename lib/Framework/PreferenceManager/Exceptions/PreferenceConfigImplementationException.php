<?php

declare(strict_types=1);

namespace Framework\PreferenceManager\Exceptions;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\PreferenceManager\Config\PreferencesConfigInterface;

/**
 * Preference config must be implement \Framework\PreferenceManager\Config\PreferencesConfigInterface exception.
 */
class PreferenceConfigImplementationException extends ConfigImplementationException
{
    /**
     * @var string
     */
    protected $configTitle = 'Preference config';

    /**
     * @var string
     */
    protected $mustImplementInterfaceName = PreferencesConfigInterface::class;
}
