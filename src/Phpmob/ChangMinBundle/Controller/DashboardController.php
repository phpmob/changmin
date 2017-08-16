<?php

namespace Phpmob\ChangMinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ChangMin/Dashboard/index.html.twig');
    }
}
