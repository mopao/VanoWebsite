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

    /**
     *return the view of items  by customerType
     *
     */
    public function viewCustomerTypeAction($customerType, $catalogType, $_locale, $page, Request $request)
    {

    }

    /**
     *return the view of items  by product
     *
     */
    public function viewProductAction($customerType, $product , $catalogType, $_locale, $page, Request $request)
    {

    }

    /**
     *return the view of items  by category
     *
     */

    public function viewCategoryAction($customerType, $product ,$category, $catalogType, $_locale, $page, Request $request)
    {

    }

    /**
     *return the view of item
     *
     */

    public function viewAction($_locale, $id, Request $request)
    {

    }

    /**
     *return the management view of items  
     *
     */
    public function managementListItemViewAction($_locale, $page, Request $request)
    {

    }


    /**
     *return the view for the adding of item
     *
     */
    public function addAction($_locale)
    {

    }
    
    /**
     *return the view for the editing of item
     *
     */
    public function editAction($_locale, $id)
    {

    }
    
    /**
     * delete an item
     *
     */
    public function deleteAction($_locale, $id)
    {

    }




}
