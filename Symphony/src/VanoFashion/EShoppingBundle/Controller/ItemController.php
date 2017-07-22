<?php

namespace VanoFashion\EShoppingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends Controller
{   

	// return home page
    public function indexAction(Request $request)
    {
    	// On définit une nouvelle valeur pour cette variable user_id

        $request->getSession()->set('user_id', 91);
        return $this->render('VanoFashionEShoppingBundle:Item:index.html.twig');
    }

    
    public function viewCustomerTypeAction($customerType, $catalogType, $_locale, $page, Request $request)
    {

    }


    public function viewProductAction($customerType, $product , $catalogType, $_locale, $page, Request $request)
    {

    }

    public function viewCategoryAction($customerType, $product ,$category, $catalogType, $_locale, $page, Request $request)
    {

    }

    public function viewAction($_locale, $id, Request $request)
    {

    }


    public function managementListItemViewAction($_locale, $page, Request $request)
    {

    }



    public function addAction($_locale)
    {

    }

    public function editAction($_locale, $id)
    {

    }

    public function deleteAction($_locale, $id)
    {

    }




}
