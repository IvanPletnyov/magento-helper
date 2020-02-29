<?php

declare(strict_types=1);

/**
 * Create dir by provided path.
 *
 * @param $path
 * @return void
 */
function createDir($path): void
{
    mkdir($path, 0777, true);
}
