<?php

use d0niek\Whereiscash\Http\Response\HtmlResponse;
use Ds\Map;

require_once '../vendor/autoload.php';

$di = require_once '../app/config/di.php';

try {
    $di->get('kernel')->start();
} catch (\Throwable $e) {
    $parameters = new Map([
        'exception' => $e,
        'user' => $di->get('user'),
    ]);
    $errorTemplate = new HtmlResponse($di->getParam('view_path'), 'error', $parameters, $di->get('session'));
    echo $errorTemplate->getHtml();
}
