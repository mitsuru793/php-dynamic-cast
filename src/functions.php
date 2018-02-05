<?php
declare(strict_types=1);

namespace PhpCastDesign;

use Closure;
use TypeException;

/**
 * @param mixed $val
 * @param string|Closure $type
 * @return mixed
 * @throws TypeException
 */
function cast($val, $type)
{
    if ($type instanceof Closure) {
        return $type($val);
    }

    $originType = $type;

    $alias = [
        'bool' => 'boolean',
        'float' => 'double',
        'int' => 'integer',
    ];
    $type = $alias[$type] ?? $type;

    if (gettype($val) === $type) {
        return $val;
    }
    if (class_exists($type)) {
        return new $type($val);
    }

    switch ($type) {
        case 'boolean':
            return (bool)$val;
        case 'integer':
            return (int)$val;
        case 'double':
            return (double)$val;
        case 'string':
            return (string)$val;
        default:
            throw new TypeException("Type is not defined: $originType");
    }
}
