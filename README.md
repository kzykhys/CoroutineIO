CoroutineIO
===========

Coroutine based generic TCP server written in PHP5.5. This project is heavily inspired by @nikic's [great post][1].

Requirements
------------

* PHP5.5+

Installation
------------

Create or update your composer.json and run `composer update`

``` json
{
    "require": {
        "kzykhys/coroutine-io": "dev-master"
    }
}
```

Example (HTTP Server)
---------------------

Run `php example.php` and open `http://localhost:8000`

```
php example.php
```

### example.php

``` php
<?php

use CoroutineIO\Example\HttpHandler;
use CoroutineIO\Example\HttpServer;

require __DIR__ . '/vendor/autoload.php';

$server = new HttpServer(new HttpHandler());
$server->run();
```

### Class HttpServer

``` php
<?php


namespace CoroutineIO\Example;

use CoroutineIO\Exception\Exception;
use CoroutineIO\Server\Server;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class HttpServer extends Server
{

    /**
     * @param string $address example: localhost:8000
     *
     * @throws Exception
     *
     * @return resource
     */
    public function createSocket($address = 'localhost:8000')
    {
        $socket = @stream_socket_server('tcp://' . $address, $no, $str);

        if (!$socket) {
            throw new Exception("$str ($no)");
        }

        return $socket;
    }

}
```

### Class HttpHandler

``` php
<?php


namespace CoroutineIO\Example;

use CoroutineIO\Server\AbstractHandler;
use CoroutineIO\Socket\ProtectedSocket;

/**
 * Simple HTTP Server Implementation
 *
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class HttpHandler extends AbstractHandler
{

    /**
     * {@inheritdoc}
     */
    public function handleRequest($input, ProtectedSocket $socket)
    {
        // Displays request information
        echo $socket->getRemoteName() . "\n";
        echo $input;

        return "HTTP/1.1 200 OK\nContent-Type: text/plain\nContent-Length: 5\n\nHello";
    }

}
```

License
-------

The MIT License

Author
------

Kazuyuki Hayashi (@kzykhys)


[1]: http://nikic.github.io/2012/12/22/Cooperative-multitasking-using-coroutines-in-PHP.html "Cooperative multitasking using coroutines (in PHP!)"