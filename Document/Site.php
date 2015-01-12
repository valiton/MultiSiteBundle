<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle\Document;

use Doctrine\ODM\PHPCR\Document\File;
use Doctrine\ODM\PHPCR\Document\Generic;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    /** @var string */
    protected $name;

    /** @var array */
    protected $domains;

    /** @var string */
    protected $canonicalDomain;

    /** @var string */
    protected $theme;

    /** @var string */
    protected $locale;

    /** @var string */
    protected $metaTitle;

    /** @var string */
    protected $metaDescription;

    /** @var string */
    protected $metaKeywords;

    /** @var string */
    protected $robotsTxt;

    /** @var File */
    protected $favicon;

    /** @var UploadedFile */
    protected $faviconFile;

    /** @var Generic */
    protected $menuRoot;

    /** @var Generic */
    protected $contentRoot;

    /** @var MultiSiteRoute */
    protected $routesRoot;

    /** @var Generic */
    protected $mediaRoot;

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
     * @param string $robotsTxt
     */
    public function setRobotsTxt($robotsTxt)
    {
        $this->robotsTxt = $robotsTxt;
    }

    /**
     * @return string
     */
    public function getRobotsTxt()
    {
        return $this->robotsTxt;
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

    /**
     * @param \Doctrine\ODM\PHPCR\Document\File $favicon
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;
    }

    /**
     * @return \Doctrine\ODM\PHPCR\Document\File
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $faviconFile
     */
    public function setFaviconFile($faviconFile)
    {
        $this->faviconFile = $faviconFile;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFaviconFile()
    {
        return $this->faviconFile;
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

    /**
     * @param \Doctrine\ODM\PHPCR\Document\Generic $mediaRoot
     */
    public function setMediaRoot($mediaRoot)
    {
        $this->mediaRoot = $mediaRoot;
    }

    /**
     * @return \Doctrine\ODM\PHPCR\Document\Generic
     */
    public function getMediaRoot()
    {
        if (null === $this->mediaRoot) {
            $this->mediaRoot = new Generic();
            $this->mediaRoot->setParent($this);
            $this->mediaRoot->setNodename('mediaRoot');
        }
        return $this->mediaRoot;
    }



}