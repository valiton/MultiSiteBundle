<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Document;


use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class MultiSiteRoute extends Route
{

    public function getStaticPrefix()
    {
        return $this->generateStaticPrefix($this->id, $this->getRoutesRoot()->getId());
    }

    /**
     * return the first parent that is not instance of a route
     */
    protected function getRoutesRoot()
    {
        $root = $this;
        while ($root && !$root instanceof Site) {
            $root = $root->getParent();
        }
        if ($root) {
            return $root->getRoutesRoot();
        }
        return null;
    }
}