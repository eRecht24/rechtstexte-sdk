<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

/**
 * Class Client
 * @package eRecht24\RechtstexteSDK
 *
 * @property int client_id
 * @property int project_id
 * @property string push_method
 * @property string push_uri
 * @property string cms
 * @property string cms_version
 * @property string plugin_name
 * @property string author_mail
 * @property string created_at
 * @property string updated_at
 */
class Client extends BaseModel
{
    /**
     * @var array
     */
    protected $properties = [
        'client_id',
        'project_id',
        'push_method',
        'push_uri',
        'cms',
        'cms_version',
        'plugin_name',
        'author_mail',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $secret;

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string|null $secret
     * @return Client
     */
    public function setSecret(?string $secret): Client
    {
        $this->secret = (string) $secret;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getAttribute('created_at');
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getAttribute('updated_at');
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->getAttribute('client_id');
    }

    /**
     * @param int|null $clientId
     * @return Client
     */
    public function setClientId(?int $clientId): Client
    {
        $this->setAttribute('client_id', (int) $clientId);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->getAttribute('project_id');
    }

    /**
     * @param int $projectId
     * @return Client
     */
    public function setProjectId(int $projectId): Client
    {
        $this->setAttribute('project_id', $projectId);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushMethod(): ?string
    {
        return $this->getAttribute('push_method');
    }

    /**
     * @param string $pushMethod
     * @return Client
     */
    public function setPushMethod(string $pushMethod): Client
    {
        $this->setAttribute('push_method', $pushMethod);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushUri(): ?string
    {
        return $this->getAttribute('push_uri');
    }

    /**
     * @param string $pushUri
     * @return Client
     */
    public function setPushUri(string $pushUri): Client
    {
        $this->setAttribute('push_uri', $pushUri);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCms(): ?string
    {
        return $this->getAttribute('cms');
    }

    /**
     * @param string $cms
     * @return Client
     */
    public function setCms(string $cms): Client
    {
        $this->setAttribute('cms', $cms);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCmsVersion(): ?string
    {
        return $this->getAttribute('cms_version');
    }

    /**
     * @param string $cmsVersion
     * @return Client
     */
    public function setCmsVersion(string $cmsVersion): Client
    {
        $this->setAttribute('cms_version', $cmsVersion);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPluginName(): ?string
    {
        return $this->getAttribute('plugin_name');
    }

    /**
     * @param string $pluginName
     * @return Client
     */
    public function setPluginName(string $pluginName): Client
    {
        $this->setAttribute('plugin_name', $pluginName);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthorMail(): ?string
    {
        return $this->getAttribute('author_mail');
    }

    /**
     * @param string $authorMail
     * @return Client
     */
    public function setAuthorMail(string $authorMail): Client
    {
        $this->setAttribute('author_mail', $authorMail);

        return $this;
    }
}