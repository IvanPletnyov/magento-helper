<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Config;

/**
 * Object manager configuration file interface.
 */
interface ObjectManagerConfigInterface
{
    /**
     * Return object manager implementation class name.
     *
     * @return string
     */
    public function getImplementationClassName(): string;
}
