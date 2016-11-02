<?php

namespace FL\PlivoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fl_plivo');

        $rootNode
            ->children()
                ->scalarNode('sms_incoming_class')
                    ->cannotBeEmpty()
                    ->defaultValue('Plivo\Model\SmsIncoming')
                ->end()
                ->scalarNode('sms_outgoing_class')
                    ->cannotBeEmpty()
                    ->defaultValue('Plivo\Model\SmsOutgoing')
                ->end()
                ->booleanNode('development_mode')
                    ->defaultFalse()
                ->end()
                ->arrayNode('from_phone_numbers')
                    ->cannotBeEmpty()
                    ->isRequired()
                    ->prototype('scalar')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
