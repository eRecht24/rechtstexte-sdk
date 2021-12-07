<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\Model\LegalText;

use PHPUnit\Framework\TestCase;

final class LegalTextTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $legalText = new LegalText([
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ]);
        $this->assertInstanceOf(
            LegalText::class,
            $legalText
        );
    }

    public function testCanFill(): void
    {
        $legalText = new LegalText([
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ]);

        $updates = [
            "html_de" => "Impressum neu",
            "html_en" => "Imprint new",
        ];

        $legalText->fill($updates);

        foreach ($updates as $key => $value)
            $this->assertSame($value, $legalText->$key);
    }

    public function testUnsetPropertiesAreNotInitialized(): void
    {
        $attributes = [
            "html_de" => "html_de",
            "html_en" => "html_en",
        ];
        $legalText = new LegalText($attributes);

        $notExpectedKeys = array_diff(
            array_keys($legalText->getFillable()),
            array_keys($attributes)
        );

        $attributes = $legalText->getAttributes();
        foreach ($notExpectedKeys as $key)
            $this->assertArrayNotHasKey($key, $attributes);
    }

    public function testSetAttribute(): void
    {
        $legalText = new LegalText();

        $legalText->setAttribute('created', 100);

        $this->assertSame(100, $legalText->created);
    }

    public function testGetAttribute(): void
    {
        $legalText = new LegalText([
            "created" => 1,
        ]);

        $this->assertSame(1, $legalText->getAttribute('created'));
    }

    public function testIgnoreInvalidProperties(): void
    {
        $valid = [
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ];

        $invalid = [
            'invalid_property_1' => 'invalid',
            'invalid_property_2' => 'invalid 2',
        ];

        $legalText = new LegalText(array_merge($valid, $invalid));

        foreach ($valid as $key => $value)
            $this->assertSame($value, $legalText->$key);

        foreach ($invalid as $key => $value)
            $this->assertSame(null, $legalText->$key);
    }

    public function testCanHandleValidType(): void
    {
        $legalText = new LegalText();

        $legalText->setType(LegalText::TYPE_IMPRINT);
        $this->assertSame(LegalText::TYPE_IMPRINT, $legalText->getType());

        $legalText->setType(LegalText::TYPE_PRIVACY_POLICY);
        $this->assertSame(LegalText::TYPE_PRIVACY_POLICY, $legalText->getType());

        $legalText->setType(LegalText::TYPE_PRIVACY_POLICY_SOCIAL_MEDIA);
        $this->assertSame(LegalText::TYPE_PRIVACY_POLICY_SOCIAL_MEDIA, $legalText->getType());
    }

    public function testCanNotSetInvalidType(): void
    {
        $legalText = new LegalText();

        $legalText->setType('Home');
        $this->assertSame(null, $legalText->getType());
    }
}