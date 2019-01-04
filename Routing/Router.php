<?php

namespace NetBull\RoutingBundle\Routing;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class Router
 * @package NetBull\RoutingBundle\Routing
 */
class Router implements RouterInterface
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var RequestContext
     */
    private $requestContext;

    /**
     * @var UrlMatcherInterface
     */
    private $urlMatcher;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ModularRouter constructor.
     */
    public function __construct()
    {
        $this->routeCollection = new RouteCollection;
    }

    /**
     * @param \NetBull\RoutingBundle\Routing\RouteCollectionProviderInterface $routeCollectionProvider
     */
    public function addRouteCollectionProvider(RouteCollectionProviderInterface $routeCollectionProvider)
    {
        $this->routeCollection->addCollection($routeCollectionProvider->getRouteCollection());
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * @param RequestContext $requestContext
     */
    public function setContext(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    /**
     * @param $name
     * @param array $parameters
     * @param $referenceType
     * @return string
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getUrlGenerator()
            ->generate($name, $parameters, $referenceType);
    }

    /**
     * @param $pathInfo
     * @return array
     */
    public function match($pathInfo)
    {
        return $this->getUrlMatcher()
            ->match($pathInfo);
    }

    /**
     * @return string
     */
    public function getContext()
    {
        // this method is never used
        return '...';
    }

    /**
     * @return UrlGeneratorInterface
     */
    private function getUrlGenerator()
    {
        if ($this->urlGenerator) {
            return $this->urlGenerator;
        }

        return $this->urlGenerator = new UrlGenerator($this->getRouteCollection(), $this->requestContext);
    }

    /**
     * @return UrlMatcherInterface
     */
    private function getUrlMatcher()
    {
        if ($this->urlMatcher) {
            return $this->urlMatcher;
        }

        return $this->urlMatcher = new UrlMatcher($this->getRouteCollection(), $this->requestContext);
    }
}
