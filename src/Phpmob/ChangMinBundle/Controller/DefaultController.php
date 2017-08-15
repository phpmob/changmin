<?php

namespace Phpmob\ChangMinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ChangMin/Default/index.html.twig');
    }
}
