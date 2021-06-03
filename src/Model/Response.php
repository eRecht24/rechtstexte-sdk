<?php
declare(strict_types=1);

namespace ERecht24\Model;

use ERecht24\Model;

class Response extends Model
{
    protected $fillable = ['code', 'body'];

    /**
     * Provide raw response body
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->getAttribute('body');
    }

    /**
     * Provide response code
     * @return int
     */
    public function getCode(): ?int
    {
        return $this->getAttribute('code');
    }
}