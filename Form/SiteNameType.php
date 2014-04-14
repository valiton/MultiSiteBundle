<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class SiteNameType extends AbstractType
{
    /** @var SiteServiceInterface */
    protected $siteService;

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['value'] = $this->siteService->findSiteByChild($form->getData())->getName();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true,
            'disabled' => true
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'site_name';
    }

    public function getParent()
    {
        return 'text';
    }

    /**
     * @param \Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface $siteService
     */
    public function setSiteService($siteService)
    {
        $this->siteService = $siteService;
    }
}