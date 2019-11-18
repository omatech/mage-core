<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;

trait FromArray
{
    /**
     * @param array $array
     * @return static
     * @throws MethodDoesNotExistsException
     */
    public static function fromArray(array $array)
    {
        $self = new static();

        foreach ($array as $property => $value) {
            $method = $self->setMethod($property);
            $self->$method($value);
        }

        return $self;
    }

    /**
     * @param string $property
     *
     * @throws MethodDoesNotExistsException
     *
     * @return string
     */
    private function setMethod(string $property): string
    {
        $method = $this->snakeCaseToCamelCase('set'.$property);

        if (! method_exists($this, $method)) {
            throw new MethodDoesNotExistsException("Method {$method} does not exists.");
        }

        return $method;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function snakeCaseToCamelCase(string $string): string
    {
        return str_replace('_', '', lcfirst(ucwords($string, '_')));
    }
}
