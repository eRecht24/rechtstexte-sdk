<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

/**
 * Class LegalText
 * @package eRecht24\RechtstexteSDK
 *
 * @property string html_de
 * @property string html_en
 * @property string created
 * @property string modified
 * @property string warnings
 * @property string pushed
 *
 * @property string type
 */
abstract class LegalText extends BaseModel
{
    const TEXT_TYPE_IMPRINT = 'imprint';
    const TEXT_TYPE_PRIVACY_POLICY = 'privacy_policy';
    const TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA = 'privacy_policy_social_media';

    const ALLOWED_DOCUMENT_TYPES = [
        self::TEXT_TYPE_IMPRINT,
        self::TEXT_TYPE_PRIVACY_POLICY,
        self::TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA,
    ];

    /**
     * allowed properties
     *
     * @var array
     */
    protected $properties = [
        'html_de',
        'html_en',
        'created',
        'modified',
        'warnings',
        'pushed',
    ];

    /**
     * @var string
     */
    protected $type;

    /**
     * Checks if $type is a valid document type
     *
     * @param string $type
     * @return bool
     */
    public static function isValidDocumentType(string $type): bool
    {
        return in_array($type, self::ALLOWED_DOCUMENT_TYPES);
    }

    /**
     * Provide legal text type
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getAttribute('created');
    }

    /**
     * @return string|null
     */
    public function getModifiedAt(): ?string
    {
        return $this->getAttribute('modified');
    }

    /**
     * @param string $lang
     * @return string|null
     */
    public function getHtml(string $lang = 'en'): ?string
    {
        switch (strtolower($lang)) {
            case 'de':
                $html = $this->getAttribute('html_de');
                break;

            default:
                $html = $this->getAttribute('html_en');
        }

        return $html;
    }

    /**
     * @return string|null
     */
    public function getHtmlDE(): ?string
    {
        return $this->getAttribute('html_de');
    }

    /**
     * @return string|null
     */
    public function getHtmlEN(): ?string
    {
        return $this->getAttribute('html_en');
    }

    /**
     * @param string $html
     * @param string $lang
     * @return LegalText
     */
    public function setHtml(string $html, string $lang = 'en'): LegalText
    {
        switch (strtolower($lang)) {
            case 'de':
                $this->setAttribute('html_de', $html);
                break;

            default:
                $this->setAttribute('html_en', $html);
        }

        return $this;
    }

    /**
     * @param string $html
     * @return LegalText
     */
    public function setHtmlDE(string $html): LegalText
    {
        $this->setAttribute('html_de', $html);

        return $this;
    }

    /**
     * @param string $html
     * @return LegalText
     */
    public function setHtmlEN(string $html): LegalText
    {
        $this->setAttribute('html_en', $html);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWarnings(): ?string
    {
        return $this->getAttribute('warnings');
    }

    /**
     * @param string $warnings
     * @return LegalText
     */
    public function setWarnings(string $warnings): LegalText
    {
        $this->setAttribute('warnings', $warnings);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushed(): ?string
    {
        return $this->getAttribute('pushed');
    }

    /**
     * @param string $pushed
     * @return LegalText
     */
    public function setPushed(string $pushed): LegalText
    {
        $this->setAttribute('pushed', $pushed);

        return $this;
    }
}