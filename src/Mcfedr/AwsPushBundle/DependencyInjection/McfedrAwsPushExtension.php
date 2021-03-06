<?php

namespace Mcfedr\AwsPushBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class McfedrAwsPushExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('mcfedr_aws_push.platforms', $config['platforms']);
        if (isset($config['aws'])) {
            if (isset($config['aws']['key'])) {
                $container->setParameter('mcfedr_aws_push.aws.key', $config['aws']['key']);
            }
            if (isset($config['aws']['secret'])) {
                $container->setParameter('mcfedr_aws_push.aws.secret', $config['aws']['secret']);
            }
            if (isset($config['aws']['region'])) {
                $container->setParameter('mcfedr_aws_push.aws.region', $config['aws']['region']);
            }
        }
        $container->setParameter('mcfedr_aws_push.debug', $config['debug']);

        if (isset($config['topic_arn'])) {
            $container->setParameter('mcfedr_aws_push.topic_arn', $config['topic_arn']);
        }
    }
}
