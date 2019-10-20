<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;

trait FromArray
{
    public static function fromArray(array $array): self
    {
        $self = new static;

        foreach ($array as $property => $value) {
            $method = $self->setMethod($property);
            $self->$method($value);
        }

        return $self;
    }

    private function setMethod($property)
    {
        $method = $this->snakeCaseToCamelCase('set'.$property);

        if (! method_exists($this, $method)) {
            throw new MethodDoesNotExistsException("Method {$method} does not exists.");
        }

        return $method;
    }

    private function snakeCaseToCamelCase($string)
    {
        return str_replace('_', '', lcfirst(ucwords($string, '_')));
    }
}
