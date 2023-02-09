<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Valiton\Bundle\MultiSiteBundle\Templating\SiteHelper;

class SiteExtension extends AbstractExtension implements GlobalsInterface
{
    /** @var  SiteHelper */
    protected $siteHelper;

    function __construct(SiteHelper $siteHelper)
    {
        $this->siteHelper = $siteHelper;
    }

    public function getGlobals(): array
    {
        return array('site' => $this->siteHelper);
    }

    public function getFilters()
    {
        return array(
            'base64_icon' => new TwigFilter('base64_icon', array($this, 'base64Icon'))
        );
    }

    public function base64Icon($icon)
    {
        return 'data:image/x-icon;base64,'.base64_encode($icon->getFileContent());
    }

}
