<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\Exception\UpdateHandlingException;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TaxonController extends ResourceController
{
    /**
     * @param Request $request
     * @param $direction
     *
     * @return Response
     */
    private function move(Request $request, $direction)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        $resource = $this->findOr404($configuration);

        $this->repository->$direction($resource);

        /** @var ResourceControllerEvent $event */
        $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::UPDATE, $configuration, $resource);

        if ($event->isStopped() && !$configuration->isHtmlRequest()) {
            throw new HttpException($event->getErrorCode(), $event->getMessage());
        }
        if ($event->isStopped()) {
            $this->flashHelper->addFlashFromEvent($configuration, $event);

            if ($event->hasResponse()) {
                return $event->getResponse();
            }

            return $this->redirectHandler->redirectToResource($configuration, $resource);
        }

        try {
            $this->resourceUpdateHandler->handle($resource, $configuration, $this->manager);
        } catch (UpdateHandlingException $exception) {
            if (!$configuration->isHtmlRequest()) {
                return $this->viewHandler->handle(
                    $configuration,
                    View::create(null, $exception->getApiResponseCode())
                );
            }

            $this->flashHelper->addErrorFlash($configuration, $exception->getFlash());

            return $this->redirectHandler->redirectToReferer($configuration);
        }

        $postEvent = $this->eventDispatcher->dispatchPostEvent(ResourceActions::UPDATE, $configuration, $resource);

        if (!$configuration->isHtmlRequest()) {
            $view = $configuration->getParameters()->get('return_content', false) ? View::create(
                $resource,
                Response::HTTP_OK
            ) : View::create(null, Response::HTTP_NO_CONTENT);

            return $this->viewHandler->handle($configuration, $view);
        }

        $this->flashHelper->addSuccessFlash($configuration, ResourceActions::UPDATE, $resource);

        if ($postEvent->hasResponse()) {
            return $postEvent->getResponse();
        }

        return $this->redirectHandler->redirectToResource($configuration, $resource);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function moveUpAction(Request $request)
    {
        return $this->move($request, 'moveUp');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function moveDownAction(Request $request)
    {
        return $this->move($request, 'moveDown');
    }
}
