RoutingBundle
==========

[![Build Status](https://travis-ci.org/netbull/RoutingBundle.svg?branch=master)](https://travis-ci.org/netbull/RoutingBundle)<br>

To add routes you usually need to add few lines to `config/routing.yml`.


**Thanks to this router, you can add them easily as via service loader**.


### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require netbull/routing-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new NetBull\RoutingBundle\NetBullRoutingBundle(),
        );

        // ...
    }

    // ...
}
```


## Usage

1. Implement [`RouteCollectionProviderInterface`](src/Contract/Routing/RouteCollectionProviderInterface.php)

    ```php
    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RouteCollection;
    use NetBull\RoutingBundle\Routing\RouteCollectionProviderInterface;
    
    class SomeRouteCollectionProvider implements RouteCollectionProviderInterface
    {
        public function getRouteCollection() : RouteCollection
        {
            $routeCollection = new RouteCollection();
            $routeCollection->add('my_route', new Route('/hello'));
    
            return $routeCollection;
        }
    }
    ```

2. Register service

    ```yml
    services:
        some_module.route_provider:
            class: SomeModule\Routing\SomeRouteCollectionProvider
            autowire: true
    ```

That's all!


### Loading YML/XML files

In case you want to load these files, just use [`AbstractRouteCollectionProvider`](src/Routing/AbstractRouteCollectionProvider.php)
with helper methods.

```php
use Symfony\Component\Routing\RouteCollection;
use NetBull\RoutingBundle\Routing\AbstractRouteCollectionProvider;

class FilesRouteCollectionProvider extends AbstractRouteCollectionProvider
{
    public function getRouteCollection(): RouteCollection
    {
        return $this->loadRouteCollectionFromFiles([
            __DIR__ . '/routes.xml',
            __DIR__ . '/routes.yml',
        ]);
        
        // on in case you have only 1 file
        // return $this->loadRouteCollectionFromFile(__DIR__ . '/routes.yml');
    }
}

```
