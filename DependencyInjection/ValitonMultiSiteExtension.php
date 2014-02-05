<?php

namespace Valiton\Bundle\MultiSiteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ValitonMultiSiteExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('valiton_multi_site.base_path', $config['base_path']);
        $container->setParameter('valiton_multi_site.default_site', $config['default_site']);

        $siteService = $container->getDefinition('valiton_multi_site.site_service');
        $siteService->replaceArgument(1, new Reference($config['manager_registry']));
        $siteService->replaceArgument(2, $config['manager_name']);

        $this->loadSonataAdmin($config, $loader, $container);
    }

    protected function loadSonataAdmin($config, Loader\XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle'])) {
            return;
        }

        $loader->load('admin.xml');
    }
}
