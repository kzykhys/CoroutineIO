CoroutineIO
===========

Fast socket server implementation using *Generator*.

This project is heavily inspired by @nikic's [great post][1].

Requirements
------------

* PHP5.5+

Installation
------------

Create or update your composer.json and run `composer update`

``` json
{
    "require": {
        "kzykhys/coroutine-io": "~1.0"
    }
}
```

Example (HTTP Server)
---------------------

1. Run `php example.php`
2. Open `http://localhost:8000` in browser and hold down the F5 key
3. Watch the console output

```
php example.php
```

```
::1:50531
GET / HTTP/1.1
Host: localhost:8000
User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:25.0) Gecko/20100101 Firefox/25.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: ja,en-us;q=0.7,en;q=0.3
Accept-Encoding: gzip, deflate
DNT: 1
Connection: keep-alive
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
 */
class HttpServer extends Server
{

    /**
     * {@inheritdoc}
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
 */
class HttpHandler extends AbstractHandler
{

    /**
     * {@inheritdoc}
     */
    public function handleRequest($input, ProtectedSocket $socket)
    {
        // "127.0.0.1:12345", "::1:50176", ...
        echo $socket->getRemoteName() . "\n";

        // Displays request header and body
        echo $input;

        // Useless server :)
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