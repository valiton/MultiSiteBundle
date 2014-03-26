<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Service;


interface RootProviderInterface
{
    /**
     * @return string
     */
    public function getRoot();

    /**
     * @param string $root
     * @return void
     */
    public function setRoot($root);
}