<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Twig;

use Valiton\Bundle\MultiSiteBundle\Templating\SiteHelper;

class SiteExtension extends \Twig_Extension
{
    /** @var  SiteHelper */
    protected $siteHelper;

    function __construct(SiteHelper $siteHelper)
    {
        $this->siteHelper = $siteHelper;
    }

    public function getGlobals()
    {
        return array('site' => $this->siteHelper);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'valiton_multi_site.site_extension';
    }

}