<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Admin;


use Sonata\AdminBundle\Exception\NoValueException;
use Sonata\DoctrinePHPCRAdminBundle\Admin\FieldDescription;
use Valiton\Bundle\MultiSiteBundle\Service\SiteServiceInterface;

class SiteFieldDescription extends FieldDescription
{
    /** @var SiteServiceInterface */
    protected $siteService;

    function __construct(SiteServiceInterface $siteService)
    {
        $this->siteService = $siteService;
    }

    public function getValue($object)
    {
        return $this->siteService->findSiteByChild($object)->getName();
    }

    public function getLabel()
    {
        return 'list.label_site';
    }


}