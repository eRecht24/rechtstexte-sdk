<?php
declare(strict_types=1);

namespace ERecht24;

abstract class Model
{
    /**
     * allowed model properties
     * @var array
     */
    protected $fillable = [];

    /**
     * The model's attributes.
     * @var array
     */
    protected $attributes = [];

    /**
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(
        array $attributes
    ) {
       $this->fill($attributes);
    }

    /**
     * Fill multiple attributes
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Fill single attribute if allowed
     * @param $key
     * @param $value
     * @return  $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->isFillable($key))
            $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Provide all attributes
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Provide single specific attribute value
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(
        string $key
    ) {
        if (array_key_exists($key, $this->getAttributes()))
            return $this->attributes[$key];

        return null;
    }

    /**
     * Get all fillable attributes for the model.
     *
     * @return array
     */
    protected function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Check if property belongs to the model
     * @param $key
     * @return bool
     */
    protected function isFillable($key)
    {
        if (in_array($key, $this->getFillable()))
            return true;

        return false;
    }

    /**
     * Magic getter
     * @param string $key
     * @return mixed|null
     */
    public function __get ( string $key )
    {
        $method = 'get'.Helper::studly($key).'Attribute';
        if (method_exists($this, $method))
            return $this->$method();

        return $this->getAttribute($key);
    }
}