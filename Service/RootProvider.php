<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Service;


class RootProvider implements RootProviderInterface
{
    /** @var string */
    protected $root;

    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $root
     * @return void
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }
}