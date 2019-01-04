<?php

namespace NetBull\RoutingBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

use NetBull\RoutingBundle\Routing\RouterInterface;
use NetBull\RoutingBundle\Routing\RouteCollectionProviderInterface;

/**
 * Class AddRouteCollectionProvidersCompilerPass
 * @package NetBull\RoutingBundle\DependencyInjection\CompilerPass
 */
class AddRouteCollectionProvidersCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function process(ContainerBuilder $containerBuilder): void
    {
        $this->loadCollectorWithType(
            $containerBuilder,
            RouterInterface::class,
            RouteCollectionProviderInterface::class,
            'addRouteCollectionProvider'
        );
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $collectorType
     * @param string $collectedType
     * @param string $setterMethod
     */
    public function loadCollectorWithType(ContainerBuilder $containerBuilder, string $collectorType, string $collectedType, string $setterMethod)
    {
        $collectorDefinitions = $this->findAllByType($containerBuilder, $collectorType);
        $collectedDefinitions = $this->findAllByType($containerBuilder, $collectedType);
        foreach ($collectorDefinitions as $collectorDefinition) {
            foreach (array_keys($collectedDefinitions) as $name) {
                $collectorDefinition->addMethodCall($setterMethod, [new Reference($name)]);
            }
        }
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $type
     * @return array
     */
    public function findAllByType(ContainerBuilder $containerBuilder, string $type): array
    {
        $definitions = [];
        foreach ($containerBuilder->getDefinitions() as $name => $definition) {
            $class = $definition->getClass() ?: $name;
            if (! is_string($class)) {
                continue;
            }
            if (is_a($class, $type, true)) {
                $definitions[$name] = $definition;
            }
        }
        return $definitions;
    }
}
