<?php

namespace Phpmob\ChangMinXBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ChangMinX/Default/index.html.twig');
    }
}
