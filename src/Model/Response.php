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

    public function getBodyDataAttribute() : array
    {
        try {
            return json_decode($this->body, true);
        } catch (Exception $e) {
            return [];
        }
    }

}