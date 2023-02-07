<?php


namespace Valiton\Bundle\MultiSiteBundle\Admin\Extension;


use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Valiton\Bundle\MultiSiteBundle\Admin\SiteFieldDescription;
use Valiton\Bundle\MultiSiteBundle\Form\SiteNameType;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class MultiSiteExtension extends AbstractAdminExtension
{
    /**
     * @var SiteServiceInterface
     */
    protected $siteService;

    /**
     * @var string
     */
    protected $formGroup;

    /**
     * @var string
     */
    protected $formTab;

    public function __construct($formGroup = 'form.group_multi_site', $formTab = 'form.tab_multi_site')
    {
        $this->formGroup = $formGroup;
        $this->formTab = $formTab;
    }

    public function configureListFields(ListMapper $list)
    {
        $list->add(new SiteFieldDescription($this->siteService));
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        if ($formMapper->hasOpenTab()) {
            $formMapper->end();
        }

        $formMapper
            ->tab($this->formTab, 'form.tab_multi_site' === $this->formTab
                ? ['translation_domain' => 'ValitonMultiSiteBundle']
                : []
            )
                ->with($this->formGroup, 'form.group_multi_site' === $this->formGroup
                    ? ['translation_domain' => 'ValitonMultiSiteBundle']
                    : []
                )
                    ->add('site', SiteNameType::class)
                ->end()
            ->end()
        ;

    }

    /**
     * @param SiteServiceInterface $siteService
     */
    public function setSiteService(SiteServiceInterface $siteService)
    {
        $this->siteService = $siteService;
    }

}
