<?php
/**
 * www.valiton.com
 *
 * @author Uwe Jäger <uwe.jaeger@valiton.com>
 */
namespace Valiton\Bundle\MultiSiteBundle;


use Valiton\Bundle\MultiSiteBundle\Document\Site;

class CurrentSite
{
    /** @var Site */
    protected $site;

    /** @var \Liip\ThemeBundle\ActiveTheme */
    protected $activeTheme;

    /** @var \Symfony\Cmf\Bundle\MenuBundle\Provider\PHPCRMenuProvider */
    protected $menuProvider;

    /** @var \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\RouteProvider */
    protected $routeProvider;

    /** @var \Symfony\Cmf\Bundle\MediaBundle\Doctrine\Phpcr\MediaManager  */
    protected $mediaManager;

    /** @var \Symfony\Cmf\Bundle\MediaBundle\File\UploadFileHelperDoctrine */
    protected $uploadFileHelper;

    /** @var \Symfony\Cmf\Bundle\MediaBundle\File\UploadFileHelperDoctrine */
    protected $uploadImageHelper;

    /** @var \Symfony\Cmf\Bundle\MediaBundle\Controller\FileController */
    protected $fileController;

    /** @var \Symfony\Cmf\Bundle\MediaBundle\Controller\ImageController */
    protected $imageController;

    /**
     * @param \Liip\ThemeBundle\ActiveTheme $activeTheme
     */
    public function setActiveTheme($activeTheme)
    {
        $this->activeTheme = $activeTheme;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MenuBundle\Provider\PHPCRMenuProvider $menuProvider
     */
    public function setMenuProvider($menuProvider)
    {
        $this->menuProvider = $menuProvider;
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\RouteProvider
     */
    public function setRouteProvider($routeProvider)
    {
        $this->routeProvider = $routeProvider;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MediaBundle\Doctrine\Phpcr\MediaManager $mediaManager
     */
    public function setMediaManager($mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MediaBundle\File\UploadFileHelperDoctrine $uploadFileHelper
     */
    public function setUploadFileHelper($uploadFileHelper)
    {
        $this->uploadFileHelper = $uploadFileHelper;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MediaBundle\File\UploadFileHelperDoctrine $uploadImageHelper
     */
    public function setUploadImageHelper($uploadImageHelper)
    {
        $this->uploadImageHelper = $uploadImageHelper;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MediaBundle\Controller\FileController $fileController
     */
    public function setFileController($fileController)
    {
        $this->fileController = $fileController;
    }

    /**
     * @param \Symfony\Cmf\Bundle\MediaBundle\Controller\ImageController $imageController
     */
    public function setImageController($imageController)
    {
        $this->imageController = $imageController;
    }

    /**
     * @param mixed $site
     */
    public function setSite(Site $site)
    {
        $this->site = $site;
        if (null !== $this->activeTheme && in_array($site->getTheme(), $this->activeTheme->getThemes())) {
            $this->activeTheme->setName($site->getTheme());
        }
        if (null !== $this->menuProvider) {
            $this->menuProvider->setMenuRoot($site->getMenuRoot()->getId());
        }
        if (null !== $this->routeProvider) {
            $this->routeProvider->setPrefix($site->getRoutesRoot()->getId());
        }
        if (null !== $this->mediaManager) {
            $this->mediaManager->setRootPath($site->getMediaRoot()->getId());
        }
        if (null !== $this->uploadFileHelper) {
            $this->uploadFileHelper->setRootPath($site->getMediaRoot()->getId());
        }
        if (null !== $this->uploadImageHelper) {
            $this->uploadImageHelper->setRootPath($site->getMediaRoot()->getId());
        }
        if (null !== $this->fileController) {
            $this->fileController->setRootPath($site->getMediaRoot()->getId());
        }
        if (null !== $this->imageController) {
            $this->imageController->setRootPath($site->getMediaRoot()->getId());
        }
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }
}