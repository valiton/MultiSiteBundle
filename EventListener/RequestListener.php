<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Valiton\Bundle\MultiSiteBundle\CurrentSite;
use Valiton\Bundle\MultiSiteBundle\Service\SiteService;

class RequestListener implements EventSubscriberInterface
{
    /** @var string */
    protected $defaultSiteName;

    /** @var SiteService */
    protected $siteService;

    /** @var CurrentSite  */
    protected $currentSite;

    /** @var array */
    protected $excludePaths;

    public function __construct($defaultSiteName, SiteService $siteService, CurrentSite $currentSite, array $excludePaths)
    {
        $this->defaultSiteName = $defaultSiteName;
        $this->siteService = $siteService;
        $this->currentSite = $currentSite;
        $this->excludePaths = $excludePaths;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            // don't do anything if it's not the master request
            return;
        }

        $request = $event->getRequest();

        foreach ($this->excludePaths as $path) {
            if (substr($request->getPathInfo(), 0, strlen($path)) == $path) {
                return;
            }
        }

        $site = $this->siteService->findSite($request->getHost());

        if (null === $site) {
            $site = $this->siteService->findSiteByName($this->defaultSiteName);
        }

        if (null === $site) {
            throw new NotFoundHttpException();
        }

        if ($request->isMethodSafe() && null !== $site->getCanonicalDomain() && $request->getHost() != $site->getCanonicalDomain()) {
            $response = new RedirectResponse(str_replace($request->getHost(), $site->getCanonicalDomain(), $request->getUri()), 301);
            $event->setResponse($response);

            return;
        }

        if ($request->getPathInfo() == '/robots.txt') {
            $event->setResponse(new Response($site->getRobotsTxt() ?: 'User-agent: *'));

            return;
        }

        $this->currentSite->setSite($site);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 33)),
        );
    }
}