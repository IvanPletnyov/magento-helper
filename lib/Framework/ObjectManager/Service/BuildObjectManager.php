<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Service;

use Framework\ConfigManager\Exceptions\ConfigImplementationException;
use Framework\ObjectManager\Api\ObjectManagerInterface;
use Framework\ObjectManager\Config\ObjectManagerConfigInterface;
use Framework\ObjectManager\Exceptions\ObjectManagerConfigImplementationException;
use Framework\ObjectManager\Exceptions\ObjectManagerImplementationException;
use Framework\ObjectManager\Exceptions\ObjectManagerNotFoundException;

/**
 * Build object manager instance.
 */
class BuildObjectManager
{
    /**
     * @return ObjectManagerInterface
     * @throws ObjectManagerNotFoundException
     * @throws ObjectManagerImplementationException
     * @throws ObjectManagerConfigImplementationException
     */
    public function execute(): ObjectManagerInterface
    {
        $objectManagerImplementationClassName = $this->getObjectManagerImplementation();

        if (empty($objectManagerImplementationClassName) || !class_exists($objectManagerImplementationClassName)) {
            ObjectManagerNotFoundException::throwException();
        }

        $objectManager = new $objectManagerImplementationClassName();

        if (!$objectManager instanceof ObjectManagerInterface) {
            ObjectManagerImplementationException::throwException();
        }

        return $objectManager;
    }

    /**
     * Find object manager implementation class name.
     *
     * @return string
     * @throws ObjectManagerConfigImplementationException
     */
    private function getObjectManagerImplementation(): string
    {
        $result = '';

        foreach (OBJECT_MANAGER_CONFIG_PATHS as $searchPath) {
            foreach (glob($searchPath) as $filePath) {
                /** @var ObjectManagerConfigInterface $objectManagerConfig */
                $objectManagerConfig = require_once $filePath;
                if (!$objectManagerConfig instanceof ObjectManagerConfigInterface) {
                    throw new ObjectManagerConfigImplementationException(get_class($objectManagerConfig));
                }

                $result = $objectManagerConfig->getImplementationClassName();
            }
        }

        return $result;
    }
}
