<?php

namespace VanoFashion\EShoppingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ItemController extends Controller
{
    public function indexAction()
    {
        return $this->render('VanoFashionEShoppingBundle:Item:index.html.twig');
    }
}
