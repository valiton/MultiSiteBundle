<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */


namespace Valiton\Bundle\MultiSiteBundle\Controller;


use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Valiton\Bundle\MultiSiteBundle\CurrentSite;

class FaviconController
{
    /** @var CurrentSite */
    protected $currentSite;

    public function __construct($currentSite)
    {
        $this->currentSite = $currentSite;
    }

    public function favicon(Request $request)
    {
        if ($site = $this->currentSite->getSite()) {
            $icon = $site->getFavicon();
            if ($icon) {
                $response = new Response($icon->getFileContent());
                $response->headers->set('Content-Type', 'image/x-icon');
                return $response;
            }
        }
        throw new NotFoundHttpException();
    }
}
