<?php

global $config;
$config = array (
    'code'          => "5efe0d0fd38bffe5932cfdc2773e55b4b8bf273c",
    'access_token'  => "1c986015c086315e2200095afe2a20e53f71a659",
    'expires_in'    => 3600,
    'token_type'    => "bearer",
    'scope'         => "view_processes edit_processes",
    'refresh_token' => "ade174976fe77f12ecde7c9e1d8307ac495f443e",
);

call_user_func(function() {
    $phpunit = new DOMDocument;
    $phpunit->load(__DIR__.'/../../phpunit.xml');
    
    foreach($phpunit->getElementsByTagName('php') as $php) {
        foreach($php->getElementsByTagName('var') as $var) {
            $GLOBALS[$var->getAttribute("name")] = $var->getAttribute("value");
        }
    }
});
