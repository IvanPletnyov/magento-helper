<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Api;

/**
 * Object manager interface.
 */
interface ObjectManagerInterface
{
    /**
     * Get object from cache. If object doesn't exist creates it.
     *
     * @param string $type
     * @return mixed
     */
    public function get(string $type);

    /**
     * Create object.
     *
     * @param string $type
     * @param array $params
     * @return mixed
     */
    public function create(string $type, array $params = []);
}
