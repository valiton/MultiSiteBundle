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
        $container->setParameter('valiton_multi_site.site_class', $config['site_class']);
        $container->setParameter('valiton_multi_site.exclude_paths', $config['exclude_paths']);
        $container->setParameter('valiton_multi_site.form_group', $config['form_group']);
        $container->setParameter('valiton_multi_site.form_tab', $config['form_tab']);

        $currentSiteService = 'valiton_multi_site.default_current_site';
        if (null !== $config['current_site_service']) {
            $currentSiteService = $config['current_site_service'];
        }
        $container->setAlias('valiton_multi_site.current_site', $currentSiteService);

        $siteService = $container->getDefinition('valiton_multi_site.site_service');
        $siteService->replaceArgument(2, new Reference($config['manager_registry']));
        $siteService->replaceArgument(3, $config['manager_name']);

        if (null !== $config['allowed_sites_filter']) {
            $siteService->addArgument(new Reference($config['allowed_sites_filter']));
        }

        $this->loadSonataAdmin($config, $loader, $container);
        $this->loadElfinderDriver($config, $loader, $container);
    }

    protected function loadSonataAdmin($config, Loader\XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!$config['use_sonata_admin'] || ('auto' === $config['use_sonata_admin'] && !isset($bundles['SonataDoctrinePHPCRAdminBundle']))) {
            return;
        }

        $loader->load('admin.xml');
    }

    protected function loadElfinderDriver($config, Loader\XmlFileLoader $loader, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!$config['use_elfinder'] || ('auto' === $config['use_elfinder'] && !isset($bundles['FMElfinderBundle']))) {
            return;
        }

        $loader->load('elfinder.xml');
    }
}
