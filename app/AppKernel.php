<?php

/**
 * Societo - Provides social site platform
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the LICENSE file that was distributed with this file.
 */

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    private $doctor = false;

    public function registerBundles()
    {
        $bundles = array(
            // Third party libraries in Standard Edition
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),

            // Additional third party libraries
            new Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),

            // Basic Societo bundles
            new Societo\BaseBundle\SocietoBaseBundle(),
            new Societo\Util\StorageBundle\SocietoUtilStorageBundle(),
            new Societo\Util\MobileBundle\SocietoUtilMobileBundle(),
            new Societo\Util\DoctorBundle\SocietoUtilDoctorBundle(),
            new Societo\Util\WafBundle\SocietoUtilWafBundle(),

            new Societo\Config\DatabaseBundle\SocietoConfigDatabaseBundle(),
            new Societo\AuthenticationBundle\SocietoAuthenticationBundle(),
            new Societo\PageBundle\SocietoPageBundle(),
            new Societo\FilterableRoutingBundle\SocietoFilterableRoutingBundle(),

            // Societo bundles for specific features
            new Societo\ActivityBundle\SocietoActivityBundle(),
            new Societo\RelationshipBundle\SocietoRelationshipBundle(),
            new Societo\GroupBundle\SocietoGroupBundle(),

            // Societo "glue" bundle
            new Societo\Glue\InstallerBundle\SocietoGlueInstallerBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        $pluginBundle = new Societo\PluginBundle\SocietoPluginBundle($this->getRootDir().'/../plugins');
        $bundles[] = $pluginBundle;
        $bundles = array_merge($bundles, $pluginBundle->getPluginsAsBundle());

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function isDoctor()
    {
        return $this->doctor;
    }

    public function enableDoctor()
    {
        $this->doctor = true;
    }
}
