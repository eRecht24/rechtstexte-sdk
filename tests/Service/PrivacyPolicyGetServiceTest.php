<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\ApiClient;

use eRecht24\RechtstexteSDK\Model\LegalText;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\PrivacyPolicyGetService;
use PHPUnit\Framework\TestCase;

final class PrivacyPolicyGetServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $service = new PrivacyPolicyGetService($this->getApiClient('invalid'));
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(401, $response->code);
        $this->assertSame(null, $service->getLegalText());
        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
        $this->assertArrayHasKey('token', $response->body_data);
    }

    public function testShouldHandleValidApiKey(): void
    {
        $service = new PrivacyPolicyGetService($this->getApiClient());
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(200, $response->code);
        $this->assertSame(true, $response->isSuccess());
        $this->assertInstanceOf(
            LegalText::class,
            $service->getLegalText()
        );

        $this->assertArrayHasKey('html_de', $response->body_data);
        $this->assertArrayHasKey('html_en', $response->body_data);
        $this->assertArrayHasKey('created', $response->body_data);
        $this->assertArrayHasKey('modified', $response->body_data);
        $this->assertArrayHasKey('warnings', $response->body_data);
        $this->assertArrayHasKey('pushed', $response->body_data);

        $this->assertSame(LegalText::TYPE_PRIVACY_POLICY, $service->getLegalText()->getType());
    }

    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ): ApiClient
    {
        if ($key == "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117" && getenv('ERECHT24_API_KEY') !== false) {
            $key = getenv('ERECHT24_API_KEY');
        }
        return new ApiClient($key);
    }
}