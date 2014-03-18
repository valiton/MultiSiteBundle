<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Document;

use Doctrine\ODM\PHPCR\Document\Generic;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;

/**
 * Class Site
 * @package Valiton\Bundle\MultiSiteBundle\Document
 *
 * This class represents a site in a multisite setup
 */
class Site implements TranslatableInterface
{
    /** @var string */
    protected $id;

    /** @var object */
    protected $parent;

    /** @var string */
    protected $name;

    /** @var array */
    protected $domains;

    /** @var  string */
    protected $canonicalDomain;

    /** @var string */
    protected $theme;

    /** @var  string */
    protected $locale;

    /** @var  string */
    protected $metaTitle;

    /** @var  string */
    protected $metaDescription;

    /** @var  string */
    protected $metaKeywords;

    /** @var  Generic */
    protected $menuRoot;

    /** @var  Generic */
    protected $contentRoot;

    /** @var  Generic */
    protected $routesRoot;

    /**
     * @param array $domains
     */
    public function setDomains($domains)
    {
        $this->domains = $domains;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param object $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return object
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $canonicalDomain
     */
    public function setCanonicalDomain($canonicalDomain)
    {
        $this->canonicalDomain = $canonicalDomain;
    }

    /**
     * @return string
     */
    public function getCanonicalDomain()
    {
        return $this->canonicalDomain;
    }

    public function __toString()
    {
        return $this->getCanonicalDomain();
    }

    /**
     * @return mixed
     */
    public function getMenuRoot()
    {
        if (null === $this->menuRoot) {
            $this->menuRoot = new Generic();
            $this->menuRoot->setParent($this);
            $this->menuRoot->setNodename('menuRoot');
        }
        return $this->menuRoot;
    }

    /**
     * @return mixed
     */
    public function getContentRoot()
    {
        if (null === $this->contentRoot) {
            $this->contentRoot = new Generic();
            $this->contentRoot->setParent($this);
            $this->contentRoot->setNodename('contentRoot');
        }
        return $this->contentRoot;
    }

    /**
     * @return mixed
     */
    public function getRoutesRoot()
    {
        if (null === $this->routesRoot) {
            $this->routesRoot = new MultiSiteRoute();
            $this->routesRoot->setParent($this);
            $this->routesRoot->setName('routesRoot');
        }
        return $this->routesRoot;
    }

    /**
     * @param $routesRoot
     */
    public function setRoutesRoot($routesRoot)
    {
        $this->routesRoot = $routesRoot;
    }

}