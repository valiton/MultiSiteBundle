<?php


namespace Valiton\Bundle\MultiSiteBundle\Admin\Extension;


use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Valiton\Bundle\MultiSiteBundle\Admin\SiteFieldDescription;
use Valiton\Bundle\MultiSiteBundle\Form\SiteNameType;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class MultiSiteExtension extends AdminExtension
{
    /**
     * @var SiteServiceInterface
     */
    protected $siteService;

    public function configureListFields(ListMapper $list)
    {
        $list->add(new SiteFieldDescription($this->siteService));
    }

    public function configureFormFields(FormMapper $form)
    {
        $form->add('site', SiteNameType::class);
    }

    /**
     * @param SiteServiceInterface $siteService
     */
    public function setSiteService(SiteServiceInterface $siteService)
    {
        $this->siteService = $siteService;
    }

}
