<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class SiteType extends AbstractType
{
    /** @var SiteServiceInterface */
    protected $siteService;

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'mapped' => false,
           'choices' => $this->getSites(),
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
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
