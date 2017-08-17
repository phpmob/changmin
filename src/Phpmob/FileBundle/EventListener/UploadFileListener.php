<?php

namespace Phpmob\FileBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Phpmob\FileBundle\Model\FileInterface;
use Phpmob\FileBundle\Uploader\FileUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileListener implements EventSubscriber
{
    /**
     * @var FileUploaderInterface
     */
    private $uploader;

    public function __construct(FileUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
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
     * @param $file
     */
    private function uploadFile($file)
    {
        if (!$file instanceof FileInterface) {
            return;
        }

        // only upload new files
        if (!$file->getFile() instanceof UploadedFile) {
            return;
        }


        $olderPath = $file->getPath();
        $this->uploader->upload($file);

        try {
            // remove old file
            if ($olderPath) {
                $this->uploader->remove($this->uploader->read($olderPath));
            }
        } catch (\Exception $e) {
        }
    }
}
