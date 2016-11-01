<?php

namespace FL\PlivoBundle\DependencyInjection;

use Plivo\Model\SmsInterface;
use Plivo\Model\SmsOutgoingInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class FLPlivoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $smsOutgoing = new $config['sms_outgoing_class']();
        if (!($smsOutgoing instanceof SmsOutgoingInterface)) {
            throw new InvalidConfigurationException(sprintf(
                "Class set in fl_plivo.sms_outgoing_class is not an instance of %s",
                SmsOutgoingInterface::class
            ));
        }

        $smsIncoming = new $config['sms_incoming_class']();
        if (!($smsIncoming instanceof SmsInterface)) {
            throw new InvalidConfigurationException(
                "Class set in fl_plivo.sms_incoming_class is not an instance of %s",
                SmsInterface::class
            );
        }

        $container->setParameter('fl_plivo.sms_outgoing.class', $config['sms_outgoing_class']);
        $container->setParameter('fl_plivo.sms_incoming.class', $config['sms_incoming_class']);
        $container->setParameter('fl_plivo.development_mode', $config['development_mode']);
    }
}
