<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\PHPCR\DocumentManager;

class SiteService implements SiteServiceInterface
{
    /** @var  DocumentManager */
    protected $documentManager;

    /** @var  string */
    protected $basePath;

    public function __construct($basePath, $registry = null, $objectManagerName = null)
    {
        $this->basePath = $basePath;
        if ($registry && $registry instanceof ManagerRegistry) {
            $this->documentManager = $registry->getManager($objectManagerName);
        }
    }

    public function findSite($domain)
    {
        $qb = $this->documentManager->createQueryBuilder();

        $qb
            ->fromDocument('Valiton\Bundle\MultiSiteBundle\Document\Site', 's')
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

}
