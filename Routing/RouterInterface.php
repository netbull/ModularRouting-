<?php

namespace NetBull\RoutingBundle\Routing;

use Symfony\Component\Routing\RouterInterface as BaseRouterInterface;

/**
 * Interface ModularRouterInterface
 * @package NetBull\RoutingBundle\Routing
 */
interface RouterInterface extends BaseRouterInterface
{
    public function addRouteCollectionProvider(RouteCollectionProviderInterface $routeCollectionProvider);
}
