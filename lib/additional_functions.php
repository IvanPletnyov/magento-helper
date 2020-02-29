<?php

declare(strict_types=1);

/**
 * Translate provided message;
 */
function translate()
{
    $translateArgs = func_get_args();
    $stringToTranslate = array_shift($translateArgs);
    if (isset($translateArgs[0]) && is_array($translateArgs[0])) {
        foreach ($translateArgs[0] as $key => $value) {
            $stringToTranslate = str_replace("%{$key}", $value, $stringToTranslate);
        }
    } else {
        $stringToTranslate = sprintf($stringToTranslate, ...$translateArgs);
    }

    return $stringToTranslate;
}