<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use PhpMob\ChangMinBundle\Model\AdminUserInterface;
use PhpMob\CoreBundle\Model\WebUserInterface;
use PhpMob\MediaBundle\Model\ImageInterface;
use PhpMob\MediaBundle\Util\Base64ToFile;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class GravatarListener
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
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $imageset;

    public function __construct(
        FactoryInterface $webUserFactory,
        FactoryInterface $adminUserFactory,
        int $size = 200,
        ?string $imageset = null
    )
    {
        $this->webUserFactory = $webUserFactory;
        $this->adminUserFactory = $adminUserFactory;
        $this->size = $size;

        $imagesets = ['mm', 'identicon', 'monsterid', 'wavatar'];

        if ($imageset && !in_array($imageset, $imagesets)) {
            throw new \InvalidArgumentException("Not supported `$imageset` imageset. Supported are :" . join(', ', $imagesets));
        }

        $this->imageset = $imageset ?? $imagesets[array_rand($imagesets)];
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

            $gravatar = file_get_contents(sprintf('http://www.gravatar.com/avatar/%s?d=%s&s=%s',
                md5(strtolower($object->getEmail())),
                $this->size,
                $this->imageset
            ));

            $file = Base64ToFile::createUploadedFile('data:image/jpeg;base64,' . base64_encode($gravatar));

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
