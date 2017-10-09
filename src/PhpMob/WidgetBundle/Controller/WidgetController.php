<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\WidgetBundle\Controller;

use PhpMob\WidgetBundle\Twig\WidgetInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WidgetController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function renderAction(Request $request)
    {
        $twig = $this->get('twig');
        $widget = $request->get('widget', []);
        $widgetName = null;

        if (!$notFound = empty($widget['name'])) {
            $widgetName = $this->get('phpmob.widget.registry')->getWidgetClass($widget['name']);
            $notFound = !$twig->hasExtension($widgetName);
        }

        if ($notFound) {
            // show empty response?
            throw new NotFoundHttpException(sprintf("Not found widget: %s", $widgetName));
        }

        /** @var WidgetInterface $widgetExtension */
        $widgetExtension = $twig->getExtension($widgetName);

        if (!$widgetExtension instanceof WidgetInterface) {
            // again! show an empty?
            throw new NotFoundHttpException(sprintf("Invalid widget type: %s", $widgetName));
        }

        $options = isset($widget['options']) ? $widget['options'] : [];
        $options['visibility'] = 'away';

        // convert data type
        array_walk_recursive($options, function (&$value) {
            if (in_array(strtolower($value), ['true', 'false'])) {
                $value = strtolower($value) === 'true' ? true : false;
            }

            if (is_numeric($value)) {
                $value = (int) $value;
            }
        });

        return new Response($widgetExtension->render($twig, $options));
    }

    public function demoAction()
    {
        return $this->render('@PhpMobWidget/demo.html.twig');
    }
}
