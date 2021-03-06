<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
          new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
          new Symfony\Bundle\SecurityBundle\SecurityBundle(),
          new Symfony\Bundle\TwigBundle\TwigBundle(),
          new Symfony\Bundle\MonologBundle\MonologBundle(),
          new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
          new Symfony\Bundle\AsseticBundle\AsseticBundle(),
          new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
          new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
          new Shtumi\UsefulBundle\ShtumiUsefulBundle(), //autocomplete
          new FOS\UserBundle\FOSUserBundle(),
          new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
          new Knp\Bundle\SnappyBundle\KnpSnappyBundle(), //wkhtmltopdf
        	new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
        	new Liuggio\ExcelBundle\LiuggioExcelBundle(), //todo : remplacer par PHPSpreadsheet
        	new Fenrizbes\ColorPickerTypeBundle\FenrizbesColorPickerTypeBundle(),
        	new RC\AmChartsBundle\RCAmChartsBundle(), //funnel chart
          new CMEN\GoogleChartsBundle\CMENGoogleChartsBundle(),
        	new Nicomak\UserBundle\NicomakUserBundle(),
          new Nicomak\PaypalBundle\NicomakPaypalBundle(),
          new AppBundle\AppBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            if ('test' === $this->getEnvironment()) {
                $bundles[] = new Liip\FunctionalTestBundle\LiipFunctionalTestBundle();
            }
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
