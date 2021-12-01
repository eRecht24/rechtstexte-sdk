<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\Model\Response;

use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);
        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }

    public function testCanFill(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $updates = [
            "code" => 300,
            "body" => "Body",
        ];

        $response->fill($updates);

        foreach ($updates as $key => $value)
            $this->assertSame($value, $response->$key);
    }

    public function testUnsetPropertiesAreNull(): void
    {
        $response = new Response([
            "code" => 200,
        ]);

        $expected = [
            "code" => 200,
            "body" => null,
        ];

        $attributes = $response->getAttributes();
        foreach ($expected as $key => $value)
            $this->assertSame($value, $attributes[$key]);
    }

    public function testSetAttribute(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $response->setAttribute('code', 100);

        $this->assertSame(100, $response->code);
    }

    public function testGetAttribute(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame("", $response->getAttribute('body'));
    }

    public function testIgnoreInvalidProperties(): void
    {
        $valid = [
            "code" => 200,
            "body" => "",
        ];

        $invalid = [
            'invalid_property_1' => 'invalid',
            'invalid_property_2' => 'invalid 2',
        ];

        $response = new Response(array_merge($valid, $invalid));

        foreach ($valid as $key => $value)
            $this->assertSame($value, $response->$key);

        foreach ($invalid as $key => $value)
            $this->assertSame(null, $response->$key);
    }

    public function testIsSuccessWorks(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame(true, $response->isSuccess());

        $response->setAttribute('code', 404);
        $this->assertSame(false, $response->isSuccess());
    }

    public function testGetBodyDataAsArrayWorks(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame(null, $response->body_data);

        $newData = ["test" => "testValue"];
        $response->setAttribute('body', json_encode($newData));
        $this->assertSame($newData, $response->body_data);
    }
}