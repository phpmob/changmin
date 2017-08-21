<?php

namespace PhpMob\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PhpMobCmsBundle:Default:index.html.twig');
    }
}
