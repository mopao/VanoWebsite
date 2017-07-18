<?php

namespace VanoFashion\EShoppingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VanoFashionEShoppingBundle:Default:index.html.twig');
    }
}
