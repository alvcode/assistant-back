<?php

namespace App\Layer\Base;

class CollectionModel
{
    private array $items = [];

    public function add(Model $model): self
    {
        $this->items[] = $model;
        return $this;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function deleteByKey(string $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * Есть ли элементы в коллекции
     */
    public function existsItems(): bool
    {
        return !empty($this->items);
    }

    /**
     * Кол-во item в коллекции
     */
    public function count(): int
    {
        return count($this->items);
    }

    /*
     * Возвращает первый item коллекции
     */
    public function getFirst(): ?Model
    {
        if (count($this->items) > 0) {
            return $this->items[0];
        }
        return null;
    }

    /**
     * Преобразование объектов в массив
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->all() as $viewModel) {
            $result[] = $viewModel->toArray();
        }
        return $result;
    }

    public function loadFromCollection(
        CollectionModel $collection,
        string $itemModelClass,
        array $loadFromArrayPropertyMapping = []
    ): self {
        foreach ($collection->all() as $item) {
            $model = new $itemModelClass();
            $model->setLoadFromArrayPropertyMapping($loadFromArrayPropertyMapping);
            $model->loadFromArray($item->toArray());
            $this->add($model);
        }
        return $this;
    }

    public function usort(\Closure $callback): void
    {
        usort($this->items, $callback);
    }

    public function __clone()
    {
        foreach ($this->items as &$item) {
            if (is_object($item)) {
                $item = clone $item;
            }
        }
    }
}
