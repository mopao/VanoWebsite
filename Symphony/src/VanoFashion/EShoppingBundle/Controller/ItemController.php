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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;

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

          $this->get('session')->getFlashBag()->add('notice', 'Item has been registered !');

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

          try {

             $em = $this->getDoctrine()->getManager();
             $em->persist($product);
             $em->flush();

             $this->get('session')->getFlashBag()->add('success', 'The product has been registered successfully !');
             return $this->redirectToRoute('vano_fashion_e_shopping_website_management_itemproduct_list');
              
          } catch (UniqueConstraintViolationException $e) {

            $this->get('session')->getFlashBag()->add('info', 'This product already exists in database !');
            return $this->render('VanoFashionEShoppingBundle:Item:itemProductAdd.html.twig', array(
          'form' => $form->createView()));
              
          }         

          
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
    public function itemProductDeleteAction( $id )
    {

        $response = new Response(); 

        try {

            $em = $this->getDoctrine()->getManager();                       
            $product=$em->getRepository('VanoFashionEShoppingBundle:ItemProduct')->find($id);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $em->remove($product);
                $em->flush(); 
                $response->setContent("Request successfully processed");    
                $response->setStatusCode(Response::HTTP_OK);
                return $response;
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }

    }

    /**
     * return the view for the list of items categories
     * at management side
     */

    public function managementListProductViewAction($_locale, $page, Request $request){

       try {

         if ($page < 1) {
      
            throw new NotFoundHttpException("page does'nt exist!");

        }

        $limit=10;   
        if($request->query->get('limit')) {
            $limit=$request->query->get('limit');
        }


        $products= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemProduct')
        ->getProducts($page, $limit);

        $total=count($products);
        $nbPages = ceil($total / $limit);
        

        if ($page > $nbPages) {

          throw $this->createNotFoundException("page does'nt exist!");

        }

        return $this->render('VanoFashionEShoppingBundle:Item:managementListProduct.html.twig',
            array(
                  'products' => $products,
                  'nbPages'     => $nbPages,
                  'page'        => $page,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));
           
       } catch (NotFoundHttpException $e) {
        $this->get('session')->getFlashBag()->add('warning', $e->getMessage());
        return $this->render('VanoFashionEShoppingBundle:Item:managementListProduct.html.twig',
            array(
                  'products' => $products,
                  'nbPages'     => $nbPages,
                  'page'        => 1,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));           
       }

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
         
          try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();  
          
            $this->get('session')->getFlashBag()->add('success', 'The category has been registered successfully!');
            return $this->redirectToRoute('vano_fashion_e_shopping_website_management_itemcategory_list');
              
          } catch (UniqueConstraintViolationException $e) {

            $this->get('session')->getFlashBag()->add('info', 'This category already exists in database !');
            return $this->render('VanoFashionEShoppingBundle:Item:itemCategoryAdd.html.twig', array(
          'form' => $form->createView()));
              
          }
          

          
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
    public function itemCategoryDeleteAction( $id)
    {

        $response = new Response(); 

        try {

            $em = $this->getDoctrine()->getManager();                       
            $category=$em->getRepository('VanoFashionEShoppingBundle:ItemCategory')->find($id);
            if (!$category) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $em->remove($category);
                $em->flush(); 
                $response->setContent("Request successfully processed");    
                $response->setStatusCode(Response::HTTP_OK);
                return $response;
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }

    }
    
    /**
     * return the view for the list of items categories
     * at management side
     */

    public function managementListCategoryViewAction($_locale, $page, Request $request){

       try {

         if ($page < 1) {
      
            throw new NotFoundHttpException("page does'nt exist!");

        }

        $limit=10;   
        if($request->query->get('limit')) {
            $limit=$request->query->get('limit');
        }


        $categories= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemCategory')
        ->getCategories($page, $limit);

        $total=count($categories);
        $nbPages = ceil($total / $limit);
        

        if ($page > $nbPages) {

          throw $this->createNotFoundException("page does'nt exist!");

        }

        return $this->render('VanoFashionEShoppingBundle:Item:managementListCategory.html.twig',
            array(
                  'categories' => $categories,
                  'nbPages'     => $nbPages,
                  'page'        => $page,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));
           
       } catch (NotFoundHttpException $e) {
        $this->get('session')->getFlashBag()->add('warning', $e->getMessage());
        return $this->render('VanoFashionEShoppingBundle:Item:managementListCategory.html.twig',
            array(
                  'categories' => $categories,
                  'nbPages'     => $nbPages,
                  'page'        => 1,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));           
       }

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

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($gender);
                $em->flush(); 
              
                $this->get('session')->getFlashBag()->add('success', 'The items gender has been registered successfully!');
                return $this->redirectToRoute('vano_fashion_e_shopping_website_management_itemgender_list');
                  
            } catch (UniqueConstraintViolationException $e) {

                $this->get('session')->getFlashBag()->add('info', 'This gender already exists in database !');
                return $this->render('VanoFashionEShoppingBundle:Item:itemGenderAdd.html.twig', array(
              'form' => $form->createView()));
              
            }
          

          
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
        $response = new Response(); 

        try {

            $em = $this->getDoctrine()->getManager();                       
            $gender=$em->getRepository('VanoFashionEShoppingBundle:ItemGender')->find($id);
            if (!$gender) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $em->remove($gender);
                $em->flush(); 
                $response->setContent("Request successfully processed");    
                $response->setStatusCode(Response::HTTP_OK);
                return $response;
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }


    }

    /**
     * return the view for the list of items genders
     * at management side
     */

    public function managementListGenderViewAction($_locale, $page, Request $request){

       try {

         if ($page != 1 ) {
      
            throw new NotFoundHttpException("page does'nt exist!");

        }       


        $genders= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemGender')
        ->findAll();

        $total=count($genders);       
        
        return $this->render('VanoFashionEShoppingBundle:Item:managementListGender.html.twig',
            array(
                  'genders' => $genders,                  
                  'total'       =>$total
                  ));
           
       } catch (NotFoundHttpException $e) {
        $this->get('session')->getFlashBag()->add('warning', $e->getMessage());
        return $this->render('VanoFashionEShoppingBundle:Item:managementListGender.html.twig',
            array(
                  'genders' => $genders,
                  'total'       =>$total
                  ));           
       }

    }





}
