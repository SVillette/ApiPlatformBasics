<?php

declare(strict_types=1);

namespace App\Api\DataTransformer;

use RuntimeException;

abstract class AbstractDataTransformer
{

    protected static function throwUnprocessableObjectException($object, string $expectedClass): void
    {
        throw new RuntimeException(sprintf(
            'Unable to transform object through %s, expected object of class %s, got %s',
            static::class,
            $expectedClass,
            is_object($object) ? get_class($object) : $object
        ));
    }

}
