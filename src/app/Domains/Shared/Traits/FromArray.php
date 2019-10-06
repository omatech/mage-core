<?php

namespace Omatech\Mage\Core\Domains\Shared\Traits;

use Omatech\Mage\Core\Domains\Shared\Exceptions\MethodDoesNotExistsException;

trait FromArray
{
    /*private function validatePropertyAccessor($property)
    {
        if (!in_array($property, self::$propertyAccessors)) {
            throw new \Exception('Invalid Property');
        }
    }*/

    public static function fromArray(array $array): self
    {
        $self = new static;

        foreach ($array as $property => $value) {
            //$self->validatePropertyAccessor($property);

            $method = $self->setMethod($property);

            $self->$method($value);
        }

        return $self;
    }

    /*public function toArray(): array
    {
        $array = [];

        foreach (self::$propertyAccessors as $property) {
            $method = $this->getMethod($property);

            $array[$property] = $this->$method();
        }

        return $array;
    }*/

    private function setMethod($property)
    {
        $method = $this->snakeCaseToCamelCase('set' . $property);

        if (!method_exists($this, $method)) {
            throw new MethodDoesNotExistsException("Method {$method} does not exists.");
        }

        return $method;
    }

    /*private function getMethod($property)
    {
        $method = $this->snakeCaseToCamelCase('get' . $property);

        if (!method_exists($this, $method)) {
            throw new \Exception("Method {$method} do not exists.");
        }

        return $method;
    }*/

    private function snakeCaseToCamelCase($string)
    {
        return str_replace('_', '', lcfirst(ucwords($string, '_')));
    }
}
