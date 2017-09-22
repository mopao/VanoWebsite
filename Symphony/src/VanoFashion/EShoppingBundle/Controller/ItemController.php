<?php

namespace VanoFashion\EShoppingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanoFashion\EShoppingBundle\Form\*;

class ItemController extends Controller
{   

	// return home page
    public function indexAction(Request $request)
    {
    	
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
     *return menu website management
     *
     */

    public function menuWebsiteManagementAction(){


        return $this->render('VanoFashionEShoppingBundle:Item:menuWebsiteManagement.html.twig');

    }

    public function websiteManagementAction(){


        return $this->render('VanoFashionEShoppingBundle:Item:websiteManagement.html.twig');

    }

    /**
     *return the view for the adding of item
     *
     */
    public function itemAddAction($_locale, Request $request)
    {

        $item = new item();
        $form = $this->createForm(itemType::class, $item);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Item has been registered !');

          //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('VanoFashionEShoppingBundle:item:itemAdd.html.twig', array(
          'form' => $form->createView()));

    }
    
    /**
     *return the view for the editing of item
     *
     */
    public function itemEditAction($_locale, $id)
    {

    }
    
    /**
     * delete an item
     *
     */
    public function itemDeleteAction($_locale, $id)
    {

    }




}
