<?php

declare(strict_types=1);

namespace Framework\ObjectManager\Exceptions;

use Throwable;

/**
 * Object manager didn't find in system exception.
 */
class ObjectManagerNotFoundException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @throws self
     */
    public static function throwException(): void
    {
        throw new self('Object manager not found in system');
    }
}
