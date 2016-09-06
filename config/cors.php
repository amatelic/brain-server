<?php
return [
    'supportsCredentials' => true,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['Origin','Content-Type', 'Accept','Api-key', 'grant_type', 'Authorization'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE', 'PATCH'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];
