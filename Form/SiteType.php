<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class SiteType extends AbstractType
{
    /** @var SiteServiceInterface */
    protected $siteService;

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
           'mapped' => false,
           'choices' => $this->getSites(),
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'site';
    }

    protected function getSites()
    {
        $sites = $this->siteService->getSites();
        $result = array();
        foreach($sites as $site) {
            $result[$site->getId()] = $site->getCanonicalDomain();
        }
        return $result;
    }

    /**
     * @param SiteServiceInterface $siteService
     */
    public function setSiteService(SiteServiceInterface $siteService)
    {
        $this->siteService = $siteService;
    }


}