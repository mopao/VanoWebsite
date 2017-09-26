<?php

namespace VanoFashion\EShoppingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VanoFashion\EShoppingBundle\Form\ItemCategoryType;
use VanoFashion\EShoppingBundle\Entity\ItemCategory;
use VanoFashion\EShoppingBundle\Form\ItemProductType;
use VanoFashion\EShoppingBundle\Entity\ItemProduct;
use VanoFashion\EShoppingBundle\Form\ItemGenderType;
use VanoFashion\EShoppingBundle\Entity\ItemGender;
use VanoFashion\EShoppingBundle\Form\ItemType;
use VanoFashion\EShoppingBundle\Entity\Item;

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

        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($item);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Item has been registered !');

          //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('VanoFashionEShoppingBundle:Item:itemAdd.html.twig', array(
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


    /**
     *return the view for the adding of items product
     *
     */
    public function itemProductAddAction($_locale, Request $request)
    {

        $product = new ItemProduct();
        $form = $this->createForm(ItemProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($product);
          $em->flush();

          $request->getSession()->getFlashBag()->add('success', 'item product has been registered !');

          //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('VanoFashionEShoppingBundle:Item:itemProductAdd.html.twig', array(
          'form' => $form->createView()));

    }
    
    /**
     *return the view for the editing of item product
     *
     */
    public function itemProductEditAction($_locale, $id)
    {

    }
    
    /**
     * delete an item product
     *
     */
    public function itemProductDeleteAction($_locale, $id)
    {

    }

    /**
     *return the view for the adding of item category
     *
     */
    public function itemCategoryAddAction($_locale, Request $request)
    {

        $category = new ItemCategory();
        $form = $this->createForm(ItemCategoryType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($category);
          $em->flush();

          $request->getSession()->getFlashBag()->add('success', 'items category has been registered !');

          //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('VanoFashionEShoppingBundle:Item:itemCategoryAdd.html.twig', array(
          'form' => $form->createView()));

    }
    
    /**
     *return the view for the editing of item category
     *
     */
    public function itemCategoryEditAction($_locale, $id)
    {

    }
    
    /**
     * delete an item category
     *
     */
    public function itemCategoryDeleteAction($_locale, $id)
    {

    }

    /**
     *return the view for the adding of items gender
     *
     */
    public function itemGenderAddAction($_locale, Request $request)
    {

        $gender = new ItemGender();
        $form = $this->createForm(ItemGenderType::class, $gender);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($gender);
          $em->flush();

          $request->getSession()->getFlashBag()->add('success', 'items gender has been registered !');

          //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('VanoFashionEShoppingBundle:Item:itemGenderAdd.html.twig', array(
          'form' => $form->createView()));

    }
    
    /**
     *return the view for the editing of items gender
     *
     */
    public function itemGenderEditAction($_locale, $id)
    {

    }
    
    /**
     * delete an item gender
     *
     */
    public function itemGenderDeleteAction($_locale, $id)
    {

    }





}
