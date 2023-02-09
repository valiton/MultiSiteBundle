<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Security;


interface AllowedSitesFilter
{

    public function filterAllowedSites(\Traversable $sites);

}