<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Service;

interface SiteServiceInterface
{
    public function findSite($domain);

    public function findSiteByName($name);

}