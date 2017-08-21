<?php

namespace PhpMob\ChangMinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ChangMin/Dashboard/index.html.twig');
    }
}
