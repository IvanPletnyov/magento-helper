<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Config;

use Framework\ObjectManager\Model\ObjectManager;

/**
 * @inheritDoc
 */
class ObjectManagerConfig implements ObjectManagerConfigInterface
{
    /**
     * @inheritDoc
     */
    public function getImplementationClassName(): string
    {
        return ObjectManager::class;
    }
}

return new ObjectManagerConfig();
