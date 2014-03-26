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

    public function getFilters()
    {
        return array(
            'base64_icon' => new \Twig_SimpleFilter('base64_icon', array($this, 'base64Icon'))
        );
    }

    public function base64Icon($icon)
    {
        return 'data:image/x-icon;base64,'.base64_encode($icon->getFileContent());
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