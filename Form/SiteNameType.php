<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class SiteNameType extends AbstractType
{
    /** @var SiteServiceInterface */
    protected $siteService;

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (null !== $form->getData()->getId()) {
            $view->vars['value'] = $this->siteService->findSiteByChild($form->getData())->getName();
        } else {
            $view->vars['value'] = '';
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true,
            'disabled' => true
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    /**
     * @param SiteServiceInterface $siteService
     */
    public function setSiteService($siteService)
    {
        $this->siteService = $siteService;
    }

}
