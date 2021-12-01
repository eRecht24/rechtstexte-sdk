<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Model;

/**
 * Class LegalText
 * @package eRecht24\RechtstexteSDK
 *
 * @property int client_id
 * @property int project_id
 * @property string html_de
 * @property string html_en
 * @property string created
 * @property string modified
 * @property string warnings
 * @property string pushed
 */
class LegalText extends Model
{
    const TYPE_IMPRINT = 'imprint';
    const TYPE_PRIVACY_POLICY = 'privacy_policy';
    const TYPE_PRIVACY_POLICY_SOCIAL_MEDIA = 'privacy_policy_social_media';

    /**
     * @var string[]
     */
    protected $fillable = [
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
     * Set legal text type
     *
     * @param mixed $type
     * @return $this
     */
    public function setType(
        string $type
    ): LegalText
    {
        if (in_array($type, [self::TYPE_IMPRINT, self::TYPE_PRIVACY_POLICY, self::TYPE_PRIVACY_POLICY_SOCIAL_MEDIA]))
            $this->type = $type;

        return $this;
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
}