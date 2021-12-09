<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests;

use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Exceptions\Exception as ERecht24Exception;
use eRecht24\RechtstexteSDK\Model\Response;
use PHPUnit\Framework\TestCase;

final class ApiHandlerTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $client = new ApiHandler('test');

        $this->assertInstanceOf(ApiHandler::class, $client);
    }
}