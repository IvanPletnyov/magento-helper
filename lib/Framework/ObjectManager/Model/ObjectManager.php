<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Model;

use Framework\ObjectManager\Api\ObjectManagerInterface;
use Framework\PreferenceManager\Service\GetTypeByPreference;

/**
 * Object manager.
 */
class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var array
     */
    private $objectCache = [];

    /**
     * @var GetTypeByPreference
     */
    private $getTypeByPreference;

    /**
     * @param GetTypeByPreference $getTypeByPreference
     */
    public function __construct(
        GetTypeByPreference $getTypeByPreference = null
    ) {
        $this->getTypeByPreference = $getTypeByPreference ?? $this->get(GetTypeByPreference::class);
        $this->objectCache[ObjectManagerInterface::class] = $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $type)
    {
        if (!isset($this->objectCache[$type])) {
            $this->objectCache[$type] = $this->create($type);
        }

        return $this->objectCache[$type];
    }

    /**
     * @inheritDoc
     */
    public function create(string $type, array $params = [])
    {
        if ($this->getTypeByPreference !== null) {
            $type = $this->getTypeByPreference->execute($type);
        }
        $objectParams = $this->getConstructorParamsByObjectType($type);
        foreach ($params as $paramName => $paramValue) {
            $objectParams[$paramName] = $paramValue;
        }

        return new $type(...array_values($objectParams));
    }

    /**
     * Get params objects.
     *
     * @param string $objectType
     * @return array
     */
    private function getConstructorParamsByObjectType(string $objectType): array
    {
        $params = [];

        foreach ($this->getConstructorParams($objectType) as $param) {
            $paramValue = null;

            if ($param['paramIsOptional']) {
                $paramValue = $param['paramDefaultValue'];
            }

            if ($param['paramClass']) {
                $paramValue = $this->get($param['paramClass']);

                if ($param['paramClass'] === get_class($this)) {
                    $paramValue = $this;
                }
            }

            $params[$param['paramName']] = $paramValue;
        }

        return $params;
    }

    /**
     * Read object constructor and return params.
     *
     * @param string $objectType
     * @return array
     * @throws \ReflectionException
     */
    private function getConstructorParams(string $objectType): array
    {
        $params = [];
        $class = new \ReflectionClass($objectType);
        $constructor = $class->getConstructor();

        if ($constructor) {
            /** @var $parameter \ReflectionParameter */
            foreach ($constructor->getParameters() as $parameter) {
                $params[] = [
                    'paramName' => $parameter->getName(),
                    'paramClass' => $parameter->getClass() !== null ? $parameter->getClass()->getName() : null,
                    'paramIsOptional' => $parameter->isDefaultValueAvailable(),
                    'paramDefaultValue' => $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null,
                ];
            }
        }

        return $params;
    }
}
