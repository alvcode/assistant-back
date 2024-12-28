<?php

namespace App\Layer\Base\SimpleObjects\Dto;

use App\Layer\Base\BaseDtoCollection;

/** @method SimpleIntDto[] all() */
class SimpleIntDtoCollection extends BaseDtoCollection
{
    /**
     * Возвращает массив int[] со значениями в коллекции
     */
    public function getAsArrayIds(): array
    {
        $result = [];
        foreach ($this->all() as $simpleIntDto) {
            $result[] = $simpleIntDto->getValue();
        }
        return $result;
    }

    /**
     * Быстрое добавление значения в коллекцию без необходимости создавать SimpleIntDto. Данный метод сделает это сам
     */
    public function fastAdd(int $val): self
    {
        $dto = new SimpleIntDto();
        $dto->setValue($val);
        $this->add($dto);
        return $this;
    }

    /**
     * Проверяет, содержится ли в коллекции значение
     */
    public function isExistsValue(int $value): bool
    {
        foreach ($this->all() as $simpleIntDto) {
            if ($simpleIntDto->getValue() === $value) {
                return true;
            }
        }
        return false;
    }
}