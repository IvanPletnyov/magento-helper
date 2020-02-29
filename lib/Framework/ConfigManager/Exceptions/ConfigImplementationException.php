<?php

declare(strict_types=1);

namespace Framework\ConfigManager\Exceptions;

use Throwable;

/**
 * Throws exception if config doesn't implement related interface.
 */
class ConfigImplementationException extends \Exception
{
    /**
     * @var string
     */
    protected $configTitle = '';

    /**
     * @var string
     */
    protected $mustImplementInterfaceName = '';

    /**
     * @param string $configClassName
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $configClassName, $message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message ?: $this->getParsedExceptionMessage($configClassName);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Parse error message.
     *
     * @param string $configClassName
     * @return string
     */
    private function getParsedExceptionMessage(string $configClassName): string
    {
        return translate(
            '%0 must implement %1. Class %2 was created with wrong implementation, please check it.',
            [
                $this->configTitle,
                $this->mustImplementInterfaceName,
                $configClassName,
            ]
        );
    }
}
