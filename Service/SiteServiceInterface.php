<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Service;

use Valiton\Bundle\MultiSiteBundle\Document\Site;

interface SiteServiceInterface
{
    public function findSite($domain);

    public function findSiteByName($name);

    public function findSiteByChild($child);

    public function getSites();

    public function reload(Site $site, $locale);
}