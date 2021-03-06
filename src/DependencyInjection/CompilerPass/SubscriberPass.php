<?php

/*
 * This file is part of the CsaGuzzleBundle package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Csa\Bundle\GuzzleBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Csa Guzzle subscriber compiler pass
 *
 * @author Charles Sarrazin <charles@sarraz.in>
 */
class SubscriberPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $subscribers = $container->findTaggedServiceIds('csa_guzzle.subscriber');

        if (!count($subscribers)) {
            return;
        }

        $factory = $container->findDefinition('csa_guzzle.client_factory');

        foreach ($subscribers as $subscriber => $options) {
            $factory->addMethodCall('registerSubscriber', [
                $options[0]['alias'],
                new Reference($subscriber),
            ]);
        }
    }
}
