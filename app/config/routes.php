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
            'url' => '/add-transaction',
            'controller' => 'Transaction:Add',
        ]),
        new Map([
            'url' => '/history',
            'controller' => 'Transaction:History',
        ]),
        new Map([
            'url' => '/target',
            'controller' => 'User:Target',
        ]),
    ]
);
