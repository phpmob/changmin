<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Controller;

use FOS\RestBundle\View\View;
use PhpMob\CmsBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PageController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function viewAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        /** @var PageInterface $resource */
        $resource = $this->findOr404($configuration);

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $resource);

        $view = View::create($resource);

        if ($configuration->isHtmlRequest()) {
            if (!$tpl = $resource->getTemplateName()) {
                $tpl = $configuration->getTemplate(ResourceActions::SHOW . '.html');
            }

            $view
                ->setTemplate($tpl)
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $resource,
                    $this->metadata->getName() => $resource,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }
}
