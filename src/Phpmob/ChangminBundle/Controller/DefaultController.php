<?php

namespace Phpmob\ChangminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Changmin/Default/index.html.twig');
    }
}
