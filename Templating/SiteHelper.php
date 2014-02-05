<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Templating;

use Valiton\Bundle\MultiSiteBundle\CurrentSite;

class SiteHelper
{
    /** @var CurrentSite  */
    protected $currentSite;

    public function __construct(CurrentSite $currentSite)
    {
        $this->currentSite = $currentSite;
    }

    public function getTheme()
    {
        if (null !== $site = $this->currentSite->getSite()) {
            return $site->getTheme();
        }
        return null;
    }

    public function getMetaTitle()
    {
        if (null !== $site = $this->currentSite->getSite()) {
            return $site->getMetaTitle();
        }
        return null;
    }

    public function getMetaDescription()
    {
        if (null !== $site = $this->currentSite->getSite()) {
            return $site->getMetaDescription();
        }
        return null;
    }

    public function getMetaKeywords()
    {
        if (null !== $site = $this->currentSite->getSite()) {
            return $site->getMetaKeywords();
        }
        return null;
    }

    public function getCanonicalDomain()
    {
        if (null !== $site = $this->currentSite->getSite()) {
            return $site->getCanonicalDomain();
        }
        return null;
    }
}
