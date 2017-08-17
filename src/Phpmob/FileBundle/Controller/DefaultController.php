<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FileBundle:Default:index.html.twig');
    }
}
