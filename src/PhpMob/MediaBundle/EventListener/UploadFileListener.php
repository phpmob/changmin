<?php

namespace PhpMob\MediaBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use PhpMob\MediaBundle\Model\FileInterface;
use PhpMob\MediaBundle\Uploader\FileUploaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileListener implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
            'postRemove',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->uploadFile($args->getObject());
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->uploadFile($args->getObject());
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if (!$object instanceof FileInterface) {
            return;
        }

        $this->removeFile($object->getPath());
    }

    /**
     * @param $file
     */
    private function uploadFile($file)
    {
        if (!$file instanceof FileInterface) {
            return;
        }

        $isUploadFile = $file->getFile() instanceof UploadedFile;

        // user click remove file
        if ($file->isShouldRemove() && !$isUploadFile) {
            $this->removeFile($file->getPath());
            $file->setPath(null);

            return;
        }

        // only upload new files
        if (!$isUploadFile) {
            return;
        }

        $this->getUploader()->upload($file);
    }

    /**
     * @param $path
     */
    private function removeFile($path)
    {
        $filters = array_keys($this->getFilterManager()->getFilterConfiguration()->all());

        try {
            // remove old file
            $this->getUploader()->remove($path);
            // TODO: should check ImageInterface instance, Binary file like pdf has no filter.
            $this->getCacheManager()->remove($path, $filters);
        } catch (\Exception $e) {
        }
    }

    /**
     * @return FileUploaderInterface
     */
    private function getUploader()
    {
        return $this->container->get('phpmob.filesystem_uploader');
    }

    /**
     * @return CacheManager
     */
    private function getCacheManager()
    {
        return $this->container->get('liip_imagine.cache.manager');
    }

    /**
     * @return FilterManager
     */
    private function getFilterManager()
    {
        return $this->container->get('liip_imagine.filter.manager');
    }
}
