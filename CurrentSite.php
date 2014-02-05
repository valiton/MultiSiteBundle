<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle;

use Valiton\Bundle\MultiSiteBundle\Document\Site;

class CurrentSite
{
    /** @var  Site */
    protected $site;

    /** @var  \Liip\ThemeBundle\ActiveTheme */
    protected $activeTheme;

    /** @var  \Symfony\Cmf\Bundle\MenuBundle\Provider\PHPCRMenuProvider */
    protected $menuProvider;

    /** @var  \Symfony\Cmf\Bundle\RoutingBundle\Document\RouteProvider */
    protected $routeProvider;

    /**
     * @param \Liip\ThemeBundle\ActiveTheme $activeTheme
     */
    public function setActiveTheme($activeTheme)
    {
        $this->activeTheme = $activeTheme;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MenuBundle\Provider\PHPCRMenuProvider $menuProvider
     */
    public function setMenuProvider($menuProvider)
    {
        $this->menuProvider = $menuProvider;
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Document\RouteProvider $routeProvider
     */
    public function setRouteProvider($routeProvider)
    {
        $this->routeProvider = $routeProvider;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
        if (null !== $this->activeTheme && in_array($site->getTheme(), $this->activeTheme->getThemes())) {
            $this->activeTheme->setName($site->getTheme());
        }
        if (null !== $this->menuProvider) {
            $this->menuProvider->setMenuRoot($site->getMenuRoot()->getId());
        }
        if (null !== $this->routeProvider) {
            $this->routeProvider->setPrefix($site->getRoutesRoot()->getId());
        }
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }
}