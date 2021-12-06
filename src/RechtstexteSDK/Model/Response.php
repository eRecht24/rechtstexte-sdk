<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Exception;
use eRecht24\RechtstexteSDK\Model;

/**
 * Class Response
 * @package eRecht24\RechtstexteSDK
 *
 * @property int code
 * @property string body
 *
 * magic properties
 * @property array body_data
 */
class Response extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['code', 'body'];

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Provide response body as array
     *
     * @return ?array
     */
    public function getBodyDataAttribute(): ?array
    {
        try {
            return json_decode($this->body, true);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Function checks if request was successful
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (200 === $this->code);
    }

    /**
     * Function provides specific body_data by key
     *
     * @param string $key
     * @return mixed|null
     */
    public function getBodyDataByKey(
        string $key
    )
    {
        if (is_null($this->body_data))
            return null;

        if (!array_key_exists($key, $this->body_data))
            return null;

        return $this->body_data[$key];
    }
}