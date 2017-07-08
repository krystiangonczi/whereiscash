<?php

use Ds\Map;
use Ds\Vector;

return new Vector(
    [
        new Map([
            'url' => '/',
            'controller' => 'DefaultController',
        ]),
        new Map([
            'url' => '/login',
            'controller' => 'User:Login',
        ]),
        new Map([
            'url' => '/logout',
            'controller' => 'User:Logout',
        ]),
        new Map([
            'url' => '/register',
            'controller' => 'User:Register',
        ]),
        new Map([
            'url' => '/post/add',
            'controller' => 'Post:Add',
        ]),
        new Map([
            'url' => '/post/edit/{id}',
            'controller' => 'Post:Edit',
        ]),
    ]
);
