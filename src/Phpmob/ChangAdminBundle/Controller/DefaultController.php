<?php

namespace Phpmob\ChangAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PhpmobChangAdminBundle:Default:index.html.twig');
    }
}
