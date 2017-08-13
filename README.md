Cachet API
=================

[![CheckItOn.Us Logo](https://www.checkiton.us/img/mono-logo.png)](https://www.checkiton.us)

[![Build Status](https://travis-ci.org/checkitonus/php-cachet-api.svg?branch=master)](https://travis-ci.org/checkitonus/php-cachet-api)

Easy to use Cachet API implementation.

# Installation

```
$ composer require checkitonus/cachet-api
```

```
{
    "require": {
        "checkitonus/cachet-api": "~1"
    }
}
```

Then, in your PHP file, all you need to do is require the autoloader:

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\Cachet\Server;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://demo.cachethq.io', // The base URL for the Cachet installation
]);

// Should return pong
echo $server->ping();
```

# API Components

Once installed, you will have access to several objects all of which will hit the API and retrieve the data as needed.

Please Note: Although all of these samples are using the `Component` class, they are available for the following objects:

* CheckItOnUs\Cachet\Component
* CheckItOnUs\Cachet\ComponentGroup
* CheckItOnUs\Cachet\Incident
* CheckItOnUs\Cachet\IncidentUpdate (In development - Cachet 2.4 feature)

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://demo.cachethq.io', // The base URL for the Cachet installation
]);

// Find a component based on the name
$component = Component::on($server)->findByName('API');

// Find a component based on the ID
$component = Component::on($server)->findById(1);

// Find all components
Component::on($server)->all();
```

## CRUD Operations

### Creation

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://demo.cachethq.io', // The base URL for the Cachet installation
]);

// Fluent API
$component = (new Component($server))
                ->setName('Name Here')
                ->setStatus(Component::OPERATIONAL)
                ->create();
```

### Update

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://demo.cachethq.io', // The base URL for the Cachet installation
]);

// Fluent API
Component::on($server)
    ->findById(1)
    ->setName('Name Here')
    ->setStatus(Component::OPERATIONAL)
    ->update();
```

### Delete

```php
require_once 'vendor/autoload.php';

use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Component;

$server = new Server([
    'api_key' => 'API-KEY',
    'base_url' => 'https://demo.cachethq.io', // The base URL for the Cachet installation
]);

// Fluent API
Component::on($server)
    ->findById(1)
    ->delete();
```
