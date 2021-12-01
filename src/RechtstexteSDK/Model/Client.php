<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Model;

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
class Client extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
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
}