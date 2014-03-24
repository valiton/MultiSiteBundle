<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */

namespace Valiton\Bundle\MultiSiteBundle\Adapter\Elfinder;

use FM\ElFinderPHP\ElFinder;
use Symfony\Cmf\Bundle\MediaBundle\Adapter\ElFinder\PhpcrDriver;
use Valiton\Bundle\MultiSiteBundle\CurrentSite;

class MultiSitePhpcrDriver extends PhpcrDriver
{
    /** @var CurrentSite */
    protected $currentSite;

    public function mount(array $opts)
    {
        $options = array_merge($opts, array('path' => $this->currentSite->getSite()->getMediaRoot()->getId()));
        return parent::mount($options);
    }

    /**
     * @param CurrentSite $currentSite
     */
    public function setCurrentSite($currentSite)
    {
        $this->currentSite = $currentSite;
    }

}