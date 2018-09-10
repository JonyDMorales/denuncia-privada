<?php
return [
    'default' => 'mongousr',
    'connections' => [
        'mongousr' => [
            'driver'   => 'mongodb',
            'dsn'     => 'mongodb://integra:Integra2017@fiscadev0-shard-00-00-wntu1.mongodb.net:27017,fiscadev0-shard-00-01-wntu1.mongodb.net:27017,fiscadev0-shard-00-02-wntu1.mongodb.net:27017/test?ssl=true&replicaSet=FiscaDev0-shard-0&connectTimeoutMS=30000&authSource=admin',
            'database' => 'denuncia',
        ],
        'mongodenuncia' => [
            'driver'   => 'mongodb',
            'dsn'     => 'mongodb://integra:Integra2017@fiscadev0-shard-00-00-wntu1.mongodb.net:27017,fiscadev0-shard-00-01-wntu1.mongodb.net:27017,fiscadev0-shard-00-02-wntu1.mongodb.net:27017/test?ssl=true&replicaSet=FiscaDev0-shard-0&connectTimeoutMS=30000&authSource=admin',
            'database' => 'denuncia',
        ]
    ],
    'migrations' => 'migrations',
    'redis' => [
        'client' => 'predis',
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],
    ],
];