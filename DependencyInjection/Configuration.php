<?php

namespace Valiton\Bundle\MultiSiteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('valiton_multi_site');

        /** @noinspection PhpUndefinedMethodInspection */
        $rootNode
            ->children()
                ->scalarNode('manager_registry')->defaultValue('doctrine_phpcr')->end()
                ->scalarNode('manager_name')->defaultValue('default')->end()
                ->scalarNode('base_path')->defaultValue('/cms')->end()
                ->scalarNode('site_class')->defaultValue('Valiton\Bundle\MultiSiteBundle\Document\Site')->end()
                ->scalarNode('current_site_service')->defaultNull()->end()
                ->scalarNode('default_site')->defaultValue('main')->end()
                ->scalarNode('allowed_sites_filter')->defaultNull()->end()
                ->enumNode('use_sonata_admin')
                    ->values(array(true, false, 'auto'))
                    ->defaultValue('auto')
                ->end()
                ->enumNode('use_elfinder')
                    ->values(array(true, false, 'auto'))
                    ->defaultValue('auto')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
