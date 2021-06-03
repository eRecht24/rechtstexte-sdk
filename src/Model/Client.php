<?php
declare(strict_types=1);

namespace ERecht24\Model;

use ERecht24\Model;

/**
 * Class Response
 * @package ERecht24\Model
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