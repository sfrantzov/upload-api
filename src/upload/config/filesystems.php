<?php

return [
    'default' => 'local',

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'permissions' => [
                'file' => [
                    'public' => 0664,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0775,
                    'private' => 0700,
                ],
            ],
        ],

        'awss3' => [
            'driver'          => 'awss3',
            'key'             => 'your-key',
            'secret'          => 'your-secret',
            'bucket'          => 'your-bucket',
            'region'          => 'your-region',
            'version'         => 'latest',
            // 'bucket_endpoint' => false,
            // 'calculate_md5'   => true,
            // 'scheme'          => 'https',
            // 'endpoint'        => 'your-url',
            // 'prefix'          => 'your-prefix',
            // 'visibility'      => 'public',
            // 'pirate'          => false,
            // 'eventable'       => true,
            // 'cache'           => 'foo'
        ],

        'azure' => [
            'driver'       => 'azure',
            'account-name' => 'your-account-name',
            'api-key'      => 'your-api-key',
            'container'    => 'your-container',
            // 'visibility'   => 'public',
            // 'pirate'       => false,
            // 'eventable'    => true,
            // 'cache'        => 'foo'
        ],

        'copy' => [
            'driver'          => 'copy',
            'consumer-key'    => 'your-consumer-key',
            'consumer-secret' => 'your-consumer-secret',
            'access-token'    => 'your-access-token',
            'token-secret'    => 'your-token-secret',
            // 'prefix'          => 'your-prefix',
            // 'visibility'      => 'public',
            // 'pirate'          => false,
            // 'eventable'       => true,
            // 'cache'           => 'foo'
        ],

        'dropbox' => [
            'driver'     => 'dropbox',
            'token'      => 'your-token',
            'app'        => 'your-app',
            // 'prefix'     => 'your-prefix',
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'ftp' => [
            'driver'     => 'ftp',
            'host'       => 'ftp.example.com',
            'port'       => 21,
            'username'   => 'your-username',
            'password'   => 'your-password',
            // 'root'       => '/path/to/root',
            // 'passive'    => true,
            // 'ssl'        => true,
            // 'timeout'    => 20,
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'gridfs' => [
            'driver'     => 'gridfs',
            'server'     => 'mongodb://localhost:27017',
            'database'   => 'your-database',
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'null' => [
            'driver'    => 'null',
            // 'eventable' => true,
            // 'cache'     => 'foo'
        ],

        'rackspace' => [
            'driver'     => 'rackspace',
            'endpoint'   => 'your-endpoint',
            'region'     => 'your-region',
            'username'   => 'your-username',
            'apiKey'     => 'your-api-key',
            'container'  => 'your-container',
            // 'internal'   => false,
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'replicate' => [
            'driver'     => 'replicate',
            'source'     => 'your-source-adapter',
            'replica'    => 'your-replica-adapter',
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'sftp' => [
            'driver'     => 'sftp',
            'host'       => 'sftp.example.com',
            'port'       => 22,
            'username'   => 'your-username',
            'password'   => 'your-password',
            // 'privateKey' => 'path/to/or/contents/of/privatekey',
            // 'root'       => '/path/to/root',
            // 'timeout'    => 20,
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'webdav' => [
            'driver'     => 'webdav',
            'baseUri'    => 'http://example.org/dav/',
            'userName'   => 'your-username',
            'password'   => 'your-password',
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

        'zip' => [
            'driver'     => 'zip',
            'path'       => storage_path('files.zip'),
            // 'visibility' => 'public',
            // 'pirate'     => false,
            // 'eventable'  => true,
            // 'cache'      => 'foo'
        ],

    ],
];
