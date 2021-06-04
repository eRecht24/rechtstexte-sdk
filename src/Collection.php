<?php
declare(strict_types=1);

namespace ERecht24;

class Collection
{
    /**
     * The items contained in the collection.
     * @var array
     */
    protected $items = [];

    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct(
        array $items = []
    ) {
        $this->items = $items;
    }

    /**
     * Get all of the items in the collection.
     * @return array
     */
    public function all() : array
    {
        return $this->items;
    }

    /**
     * Get an item from the collection by key.
     * @param  mixed  $key
     * @return mixed
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->items))
            return $this->items[$key];


        return null;
    }

    /**
     * Determine if the collection is empty or not.
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->items);
    }

    /**
     * Count the number of items in the collection.
     * @return int
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * Push one or more items onto the end of the collection.
     * @param  mixed  $values [optional]
     * @return $this
     */
    public function push(...$values) : Collection
    {
        foreach ($values as $value)
            $this->items[] = $value;

        return $this;
    }

    /**
     * Add an item to the collection.
     * @param  mixed  $item
     * @return Collection
     */
    public function add($item) : Collection
    {
        $this->items[] = $item;

        return $this;
    }
}