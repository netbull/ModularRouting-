<?php

namespace NetBull\RoutingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use NetBull\RoutingBundle\DependencyInjection\NetBullRoutingExtension;
use NetBull\RoutingBundle\DependencyInjection\CompilerPass\AddRouteCollectionProvidersCompilerPass;

/**
 * Class NetBullRoutingBundle
 * @package NetBull\RoutingBundle
 */
class NetBullRoutingBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function getContainerExtension()
    {
        return new NetBullRoutingExtension;
    }

    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new AddRouteCollectionProvidersCompilerPass);
    }
}
