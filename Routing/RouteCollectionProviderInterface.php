<?php

namespace NetBull\RoutingBundle\Routing;

use Symfony\Component\Routing\RouteCollection;

/**
 * Interface RouteCollectionProviderInterface
 * @package NetBull\RoutingBundle\Routing
 */
interface RouteCollectionProviderInterface
{
    public function getRouteCollection(): RouteCollection;
}
