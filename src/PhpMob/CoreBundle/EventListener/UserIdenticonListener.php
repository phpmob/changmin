<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use Identicon\Identicon;
use PhpMob\ChangMinBundle\Model\AdminUserInterface;
use PhpMob\CoreBundle\Model\WebUserInterface;
use PhpMob\MediaBundle\Model\ImageInterface;
use PhpMob\MediaBundle\Util\Base64ToFile;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class UserIdenticonListener
{
    /**
     * @var FactoryInterface
     */
    private $webUserFactory;

    /**
     * @var FactoryInterface
     */
    private $adminUserFactory;

    /**
     * @var Identicon
     */
    private $identicon;

    /**
     * @var int
     */
    private $size;

    /**
     * @var array
     */
    private $colors = [];

    public function __construct(
        FactoryInterface $webUserFactory,
        FactoryInterface $adminUserFactory,
        Identicon $identicon,
        int $size = 200,
        array $colors = ['#007bff']
    )
    {
        $this->webUserFactory = $webUserFactory;
        $this->adminUserFactory = $adminUserFactory;
        $this->identicon = $identicon;
        $this->size = $size;
        $this->colors = $colors;
    }

    /**
     * @param OnFlushEventArgs $onFlushEventArgs
     */
    public function onFlush(OnFlushEventArgs $onFlushEventArgs)
    {
        $entityManager = $onFlushEventArgs->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        $this->processEntities($unitOfWork->getScheduledEntityInsertions(), $entityManager, $unitOfWork);
        $this->processEntities($unitOfWork->getScheduledEntityUpdates(), $entityManager, $unitOfWork);
    }

    /**
     * @param array $entities
     * @param EntityManagerInterface $entityManager
     * @param UnitOfWork $unitOfWork
     */
    private function processEntities(array $entities, EntityManagerInterface $entityManager, UnitOfWork $unitOfWork): void
    {
        /** @var AdminUserInterface|WebUserInterface $object */
        foreach ($entities as $object) {
            $isAdminUser = $object instanceof AdminUserInterface;
            $isWebUser = $object instanceof WebUserInterface;

            if (!$isAdminUser && !$isWebUser) {
                continue;
            }

            if ($object->getPicture()) {
                continue;
            }

            $file = Base64ToFile::createUploadedFile(
                $this->identicon->getImageDataUri($object->getUsername(), $this->size, $this->colors[array_rand($this->colors, 1)])
            );

            /** @var ImageInterface $picture */
            $picture = $isAdminUser ? $this->adminUserFactory->createNew() : $this->webUserFactory->createNew();
            $picture->setFile($file);
            $picture->setCaption($object->getUsername());

            $object->setPicture($picture);

            $entityManager->persist($picture);

            /** @var ClassMetadata $metadata */
            $metadata = $entityManager->getClassMetadata(get_class($picture));
            $unitOfWork->computeChangeSet($metadata, $picture);
        }
    }
}
