<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/graphql', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
    'query' => 'query { allBagian { id nama } }'
]));
$response = $kernel->handle($request);
echo $response->getContent();
