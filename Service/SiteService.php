<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ODM\PHPCR\DocumentManager;
use Valiton\Bundle\MultiSiteBundle\Security\AllowedSitesFilter;

class SiteService implements SiteServiceInterface
{
    /** @var DocumentManager */
    protected $documentManager;

    /** @var string */
    protected $basePath;

    /** @var string */
    protected $siteClass;

    /** @var AllowedSitesFilter */
    protected $allowedSitesFilter;

    public function __construct($basePath, $siteClass, ManagerRegistry $registry = null, $objectManagerName = null, AllowedSitesFilter $allowedSitesFilter = null)
    {
        $this->basePath = $basePath;
        $this->siteClass = $siteClass;
        $this->documentManager = $registry->getManager($objectManagerName);
        $this->allowedSitesFilter = $allowedSitesFilter;
    }

    public function findSite($domain)
    {
        $qb = $this->documentManager->createQueryBuilder();

        $qb
            ->fromDocument($this->siteClass, 's')
            ->where()->eq()->field('s.domains')->literal($domain)->end()->end()
            ->orWhere()->eq()->field('s.canonicalDomain')->literal($domain)->end()->end()
        ;

        /** @var ArrayCollection $result */
        $result = $qb->getQuery()->execute();
        if (null !== $result && count($result) > 0) {
            return $result->current();
        }

        return null;
    }

    public function findSiteByName($name)
    {
        return $this->documentManager->find(null, $this->basePath.'/'.$name);
    }

    public function findSiteByChild($child)
    {
        $qb = $this->documentManager->createQueryBuilder();

        $qb
            ->from()
                ->joinInner()
                    ->left()->document(ClassUtils::getClass($child), 'child')->end()
                    ->right()->document($this->siteClass, 'site')->end()
                    ->condition()
                        ->descendant('child', 'site')
                    ->end()
                ->end()
            ->end()
            ->where()->same($child->getId(), 'child')->end()
        ;

        /** @var ArrayCollection $result */
        $result = $qb->getQuery()->execute();
        if (null !== $result && count($result) > 0) {
            return $result->current();
        }

        return null;
    }

    public function getSites()
    {
        $qb = $this->documentManager->createQueryBuilder();

        $qb->fromDocument($this->siteClass, 's');
        $sites = $qb->getQuery()->execute();

        if (null !== $this->allowedSitesFilter) {
            return $this->allowedSitesFilter->filterAllowedSites($sites);
        }

        return $sites;
    }

}
