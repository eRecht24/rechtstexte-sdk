<?php
declare(strict_types=1);

namespace ERecht24;

class Response
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $body;

    /**
     * Response constructor.
     * @param int $code
     * @param string|null $body
     */
    public function __construct(
        int $code,
        ?string $body
    ) {
        $this->code = $code;
        $this->body = $body;
    }

    /**
     * Provide raw response body
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Provide response code
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}