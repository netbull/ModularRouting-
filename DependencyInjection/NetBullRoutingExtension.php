<?php

namespace NetBull\RoutingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class NetBullRoutingExtension
 * @package NetBull\RoutingBundle\DependencyInjection
 */
class NetBullRoutingExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $containerBuilder
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
