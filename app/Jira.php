<?php

namespace App;

use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Issues\Walker;

/**
 * Description of Main
 *
 * @author davidcallizaya
 */
class Jira
{
    /**
     *
     * @var Walker
     */
    public $walker;

    /**
     *
     * @var JiraApi
     */
    public $api;

    public function __construct($server, $user, $password)
    {
        $this->api = new JiraApi(
            $server,
            new Basic($user, $password)
        );

        $this->walker = new Walker($this->api);
    }
}