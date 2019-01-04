<?php

namespace NetBull\RoutingBundle\Routing;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

use NetBull\RoutingBundle\Exception\FileNotFoundException;

/**
 * Class AbstractRouteCollectionProvider
 * @package NetBull\RoutingBundle\Routing
 */
abstract class AbstractRouteCollectionProvider implements RouteCollectionProviderInterface
{
    /**
     * @var LoaderResolverInterface
     */
    private $loaderResolver;

    /**
     * AbstractRouteCollectionProvider constructor.
     * @param LoaderResolverInterface $loaderResolver
     */
    public function __construct(LoaderResolverInterface $loaderResolver)
    {
        $this->loaderResolver = $loaderResolver;
    }

    /**
     * @param string $path
     * @return RouteCollection
     * @throws FileNotFoundException
     */
    protected function loadRouteCollectionFromFile(string $path)
    {
        $this->ensureFileExists($path);

        $loader = $this->loaderResolver->resolve($path);
        if (null === $loader) {
            return new RouteCollection;
        }

        return $loader->load($path);
    }

    /**
     * @param array $paths
     * @return RouteCollection
     * @throws FileNotFoundException
     */
    protected function loadRouteCollectionFromFiles(array $paths)
    {
        $routeCollection = new RouteCollection;

        foreach ($paths as $path) {
            $routeCollection->addCollection($this->loadRouteCollectionFromFile($path));
        }

        return $routeCollection;
    }

    /**
     * @param string $path
     * @throws FileNotFoundException
     */
    private function ensureFileExists(string $path): void
    {
        if (! file_exists($path)) {
            throw new FileNotFoundException(
                sprintf('File "%s" was not found.', $path)
            );
        }
    }
}
