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
    protected $site = false;

    public function getStaticPrefix()
    {
        return $this->generateStaticPrefix($this->id, $this->getRoutesRoot()->getId());
    }

    /**
     * return the first parent that is not instance of a route
     */
    protected function getRoutesRoot()
    {
        if ($site = $this->getSite()) {
            return $site->getRoutesRoot();
        }
        return null;
    }

    protected function getSite()
    {
        if (false === $this->site) {
            $node = $this;
            while ($node && !$node instanceof Site) {
                $node = $node->getParent();
            }
            $this->site = $node;
        }
        return $this->site;
    }

    public function getHost()
    {
        if ($site = $this->getSite()) {
            return $site->getCanonicalDomain();
        }
        return null;
    }

}