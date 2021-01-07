<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Admin;

use Doctrine\ODM\PHPCR\Document\File;
use Liip\ThemeBundle\ActiveTheme;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Valiton\Bundle\MultiSiteBundle\CurrentSite;
use Valiton\Bundle\MultiSiteBundle\Document\Site;
use Valiton\Bundle\MultiSiteBundle\Form\Loader\MediaLoader;

class SiteAdmin extends Admin
{
    protected $root;

    /** @var  ActiveTheme */
    protected $activeTheme;

    /** @var MediaLoader */
    protected $mediaLoader;

    /** @var CurrentSite */
    protected $currentSite;

    protected function configureFormFields(FormMapper $form)
    {
        $form->with('form.group_general');
        $form->add('name');
        if (null !== $this->activeTheme) {
            $form->add('theme', ChoiceType::class, array('choices' => $this->getThemes()));
        }
        $form
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('robotsTxt', TextareaType::class, array('required' => false))
            ->add('canonicalDomain')
            ->add('domains', CollectionType::class, array('allow_add' => true, 'allow_delete' => true, 'options' => array('label' => false)))
        ;

        if ($this->currentSite->getSite()->getId() == $this->getSubject()->getId()) {
            $form->add('favicon', null, array('required' => false, 'loader' => $this->mediaLoader));
        }

        $form->add('faviconFile', FileType::class, array('required' => false));
        $form->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('canonical_domain')
            ->add('metaTitle')
        ;
    }

    public function getExportFormats()
    {
        return array();
    }

    protected function getThemes()
    {
        if (null !== $this->activeTheme) {
            return array_combine($this->activeTheme->getThemes(), $this->activeTheme->getThemes());
        }
        return array();
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function setActiveTheme($activeTheme)
    {
        $this->activeTheme = $activeTheme;
    }

    public function getNewInstance()
    {
        $object = parent::getNewInstance();
        if (null === $this->activeTheme) {
            $object->setTheme('default');
        }
        return $object;
    }

    public function prePersist($object)
    {
        $object->setId($this->root.'/'.$object->getName());
        $this->upload($object);
    }

    public function preUpdate($object)
    {
        $this->upload($object);
    }


    public function toString($object)
    {
        if (null !== $object && null !== $object->getName()) {
            return $object->getName();
        }
        return $this->trans('new_site');
    }

    public function upload(Site $site)
    {
        if (null !== $uploadFile = $site->getFaviconFile()) {
            $file = $this->modelManager->find(null, $site->getMediaRoot()->getId() . '/' . $uploadFile->getClientOriginalName());
            if (null == $file) {
                $file = new File();
                $file->setNodename($uploadFile->getClientOriginalName());
                $file->setParentDocument($site->getMediaRoot());
                $file->setFileContentFromFilesystem($uploadFile->getRealPath());
                $site->setFavicon($file);
            }
            else {
                $file->setFileContentFromFilesystem($uploadFile->getRealPath());
                $site->setFavicon($file);
            }
        }
    }

    /**
     * @param MediaLoader $mediaLoader
     */
    public function setMediaLoader($mediaLoader)
    {
        $this->mediaLoader = $mediaLoader;
    }

    /**
     * @param CurrentSite $currentSite
     */
    public function setCurrentSite($currentSite)
    {
        $this->currentSite = $currentSite;
    }

}
