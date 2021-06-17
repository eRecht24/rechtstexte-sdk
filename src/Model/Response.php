<?php
declare(strict_types=1);

namespace ERecht24\Model;

use ERecht24\Exception;
use ERecht24\Model;

/**
 * Class Response
 * @package ERecht24\Model
 *
 * @property int code
 * @property string body
 *
 * magic properties
 * @property array body_data
 */
class Response extends Model
{
    protected $fillable = ['code', 'body'];

    /**
     * Provide response body as array
     * @return ?array
     */
    public function getBodyDataAttribute() : ?array
    {
        try {
            return json_decode($this->body, true);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Function checks if request was successful
     * @return bool
     */
    public function isSuccess() :bool
    {
        return (200 === $this->code);
    }

    /**
     * Function provides specific body_data by key
     * @param string $key
     * @return mixed|null
     */
    public function getBodyDataByKey(
        string $key
    ) {
        if (is_null($this->body_data))
            return null;

        if (!array_key_exists($key, $this->body_data))
            return null;

        return $this->body_data[$key];
    }
}