<?php

namespace Valiton\Bundle\MultiSiteBundle\Form\Loader;

use Doctrine\ODM\PHPCR\Document\File;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Valiton\Bundle\MultiSiteBundle\CurrentSite;

/**
 * @author Markus Lehmann (markus.lehmann@valiton.com)
 * @copyright Copyright2014, Valiton GmbH
 */
class MediaLoader implements EntityLoaderInterface
{

    /**
     * @var CurrentSite
     */
    protected $currentSite;

    /**
     * @var DocumentManager
     */
    protected $documentManager;

    public function __construct(CurrentSite $currentSite,
                                DocumentManager $documentManager)
    {
        $this->currentSite = $currentSite;
        $this->documentManager = $documentManager;
    }

    /**
     * Returns an array of entities that are valid choices in the corresponding choice list.
     *
     * @return array The entities.
     */
    public function getEntities()
    {
        $mediaRoot = $this->currentSite->getSite()->getMediaRoot();

        $result = array();
        if (isset($mediaRoot)) {
            $qb = $this->documentManager->createQueryBuilder();
            $qb
                ->fromDocument('Doctrine\ODM\PHPCR\Document\Resource', 'r')
                ->where()
                    ->orX()
                        ->eq()->field('r.mimeType')->literal('image/vnd.microsoft.icon')->end()
                        ->eq()->field('r.mimeType')->literal('image/x-ico')->end()
                        ->eq()->field('r.mimeType')->literal('image/x-icon')->end()
                    ->end()
                ->end()
                ->andWhere()
                    ->descendant($mediaRoot->getId(), 'r')
                ->end()
            ;
            $resources = $qb->getQuery()->execute();
            foreach ($resources as $resource) {
                $file = $resource->getParent();
                $result[$file->getId()] = $file;
            }
        }
        return $result;
    }


    /**
     * Returns an array of entities matching the given identifiers.
     *
     * @param string $identifier The identifier field of the object. This method
     *                           is not applicable for fields with multiple
     *                           identifiers.
     * @param array  $values     The values of the identifiers.
     *
     * @return array The entities.
     */
    public function getEntitiesByIds($identifier, array $values)
    {
        return $this->documentManager->findMany(null, $values);
    }
}
