<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Admin\Extension;


use Doctrine\ODM\PHPCR\DocumentManager;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Valiton\Bundle\MultiSiteBundle\Admin\SiteFieldDescription;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class MultiSiteExtension extends AdminExtension
{
    /** @var SiteServiceInterface */
    protected $siteService;

    public function configureListFields(ListMapper $list)
    {
        $list->add(new SiteFieldDescription($this->siteService));
    }

    public function configureFormFields(FormMapper $form)
    {
        $form->add('site', 'site_name');
    }

    /**
     * @param SiteServiceInterface $siteService
     */
    public function setSiteService(SiteServiceInterface $siteService)
    {
        $this->siteService = $siteService;
    }

}