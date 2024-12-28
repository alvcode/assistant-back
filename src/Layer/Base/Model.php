<?php

namespace App\Layer\Base;

class Model
{
    private array $loadFromArrayPropertyMap = [];

    /**
     * Правила конвертации аттрибутов в массив
     * @return array
     */
    protected function toArrayRules(): array
    {
        return [];
    }

    /**
     * Правила установки аттрибутов через массив
     * @return array
     */
    protected function loadFromArrayRules(): array
    {
        return [];
    }

    public function __get($name) {
        return $this->data[$name] ?? null;
    }

    /**
     * Установка значений через loadFromArray
     * @param $name
     * @param $value
     * @return void
     */
    protected function setProperty($name, $value): void
    {
        if (isset($this->loadFromArrayRules()[$name])) {
            $this->$name = $this->loadFromArrayRules()[$name]($value);
        } else {
            $this->$name = $value;
        }
    }

    protected function getLoadFromArrayRenamePropertyMapping(): array
    {
        return $this->loadFromArrayPropertyMap;
    }

    public function setLoadFromArrayPropertyMapping(array $loadFromArrayPropertyMap): void
    {
        $this->loadFromArrayPropertyMap = $loadFromArrayPropertyMap;
    }

    public function loadFromArray(?array $data) {
        if (is_array($data)) {
            foreach ($data as $property => $value) {
                if (
                    isset($this->getLoadFromArrayRenamePropertyMapping()[$property]) &&
                    property_exists($this, $this->getLoadFromArrayRenamePropertyMapping()[$property])
                ) {
                    $this->setProperty($this->getLoadFromArrayRenamePropertyMapping()[$property], $value);
                } else if (property_exists($this, $property)) {
                    $this->setProperty($property, $value);
                }
            }
        }
    }

    /**
     * Выполняется после loadFromArray
     * @return void
     */
    protected function afterLoadFromArray(): void
    {
        return;
    }

    public function toArray(): array
    {
        $reflectionClass = new \ReflectionClass($this);
        $attributes = [];
        $toArrayRules = $this->toArrayRules();

        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();

            if ($property->isInitialized($this)) {
                $propertyValue = $property->getValue($this);

                if (isset($toArrayRules[$propertyName])) {
                    $attributes[$propertyName] = $toArrayRules[$propertyName]();
                    continue;
                }

                if (
                    is_object($propertyValue) &&
                    (is_a($propertyValue, self::class) || method_exists($propertyValue, 'toArray'))
                ) {
                    $attributes[$propertyName] = $propertyValue->toArray();
                } else {
                    $attributes[$propertyName] = $propertyValue;
                }
            } else {
                $attributes[$propertyName] = null;
            }
        }

        return $attributes;
    }

    public function __clone() {
        foreach (get_object_vars($this) as $key => $value) {
            if (is_object($value)) {
                $this->$key = clone $value;
            }
        }
    }
}
