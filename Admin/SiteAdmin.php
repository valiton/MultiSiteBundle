<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;

class SiteAdmin extends Admin
{
    protected $root;

    /** @var  \Liip\ThemeBundle\ActiveTheme */
    protected $activeTheme;

    protected function configureFormFields(FormMapper $form)
    {
        $form->with('form.group_general');
        $form->add('name');
        if (null !== $this->activeTheme) {
            $form->add('theme', 'choice', array('choices' => $this->getThemes()));
        }
        $form
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('canonicalDomain')
            ->add('domains', 'collection', array('allow_add' => true, 'allow_delete' => true, 'options' => array('label' => false)))
        ;
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
        $object->setParent($this->getModelManager()->find(null, $this->root));
        return $object;
    }

    public function toString($object)
    {
        if (null !== $object && null !== $object->getName()) {
            return $object->getName();
        }
        return $this->trans('new_site');
    }
}
