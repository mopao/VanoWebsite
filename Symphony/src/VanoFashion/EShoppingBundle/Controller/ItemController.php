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
use VanoFashion\EShoppingBundle\Form\ItemEditType;
use VanoFashion\EShoppingBundle\Entity\Item;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ItemController extends Controller
{   
   

   //private const integer =25;
	// return home page
    public function indexAction(Request $request)
    {
        
        return $this->render('VanoFashionEShoppingBundle:Item:index.html.twig');
    }

   
    /**
     *return the main menu management
     *
     */

    public function menuAction(){

      $nberpermenu=6;
        $menu=array();
        $menu['nberpermenu']=$nberpermenu;

        /* get men general menu */
        $menMenu=array();
        // get men categories
        $categories= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemCategory')
        ->getCategories(1, $nberpermenu);

        // get men products
        $menProducts= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemProduct')
        ->getProducts(1, $nberpermenu, array('gender' => array('men','unisex')));

        // get men designers
        $menItems= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:Item')
        ->getItems(1, $nberpermenu, array('gender' => array('men','unisex')));
        $menDesigners=array();
        foreach ($menItems as $item) {
          if (!array_search($item->getBrand(),$menDesigners)) {
            # code...
            $menDesigners[]=$item->getBrand();
          }
        
        }

        $menMenu['categories']=$categories;
        $menMenu['products']=$menProducts; 
        $menMenu['designers']=$menDesigners;   

        
      /* get women general menu */
        $womenMenu=array();
         // get women products
        $womenProducts= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemProduct')
        ->getproducts(1, $nberpermenu, array('gender' => array('women','unisex')));
         
         // get women designers
         $womenItems= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:Item')
        ->getItems(1, $nberpermenu, array('gender' => array('women','unisex')));
        $womenDesigners=array();
        foreach ($womenItems as $item) {
          if (!array_search($item->getBrand(),$womenDesigners)) {
            # code...
            $womenDesigners[]=$item->getBrand();
          }
        
        }
        
        $womenMenu['categories']=$categories;
        $womenMenu['products']=$womenProducts;
        $womenMenu['designers']=$womenDesigners;


        $menu['men']=$menMenu;
        $menu['women']=$womenMenu;



        return $this->render('VanoFashionEShoppingBundle:Item:menu.html.twig',
           array('menu' => $menu));

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
          try {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Item has been registered !');

            return $this->redirectToRoute('vano_fashion_e_shopping_website_management_item_list');
            
          } catch (UniqueConstraintViolationException $e) {

            $this->get('session')->getFlashBag()->add('info', $e->getMessage());
            return $this->render('VanoFashionEShoppingBundle:Item:itemProductAdd.html.twig', array(
          'form' => $form->createView()));
            
          }
        }

        return $this->render('VanoFashionEShoppingBundle:Item:itemAdd.html.twig', array(
          'form' => $form->createView()));

    }

         /**
     * return the view for the list of items categories
     * at management side
     */

    public function managementListItemViewAction($_locale, $page, Request $request){

      if($request->isXmlHttpRequest()) {
        # code ajax request
        $array_items=array();
        $items= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:Item')
        ->findAll();

        foreach ($items as $item) {
          # code...
          $array_items[]=$item->toArray();
        }
        
        return new JsonResponse($array_items);

      }
      # code if is not an ajax request
       try {

         if ($page < 1) {
      
            throw new NotFoundHttpException("page does'nt exist!");

        }

        $limit=10;   
        if($request->query->get('limit')) {
            $limit=$request->query->get('limit');
        }

        $filter=array();
        if($request->query->get('color')){
          $filter['color']=explode(",",$request->query->get('color'));


        }

        if($request->query->get('brand')){
          $filter['brand']=explode(",",$request->query->get('brand'));


        }

        if($request->query->get('itemlabel') and $request->query->get('itemlabel')!=="all"){
          $filter['itemLabel']=explode(",",$request->query->get('itemlabel'));


        }

        if($request->query->get('product') and $request->query->get('product')!=="all"){
          $filter['product']=explode(",",$request->query->get('product'));


        }
        elseif($request->query->get('category') and $request->query->get('category')!=="all") {
           # code...
          $em = $this->getDoctrine()->getManager();                       
          $category=$em->getRepository('VanoFashionEShoppingBundle:ItemCategory')->getCategory($request->query->get('category'));
          $products=[];
          foreach ($category->getProducts() as $product) {
            # code...
            $products[]=$product->getName();
          }

          $filter['product']=$products;

        }

        if($request->query->get('gender') and $request->query->get('gender')!=="all"){
          $filter['gender']=explode(",",$request->query->get('gender'));


        }


        $items= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:Item')
        ->getItems($page, $limit, $filter);

        $total=count($items);
        $nbPages = ceil($total / $limit);
        
        if ($nbPages===0) {
            # code...
             $this->get('session')->getFlashBag()->add('info', 'no item found!');
        }
        if ($nbPages>0 and $page > $nbPages) {

          throw $this->createNotFoundException("page does'nt exist!");

        }

        return $this->render('VanoFashionEShoppingBundle:Item:managementListItem.html.twig',
            array(
                  'items' => $items,
                  'nbPages'     => $nbPages,
                  'page'        => $page,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));
           
       } catch (NotFoundHttpException $e) {
        $this->get('session')->getFlashBag()->add('danger', $e->getMessage());
        return $this->render('VanoFashionEShoppingBundle:Item:managementListItem.html.twig',
            array(
                  'items' => $items,
                  'nbPages'     => $nbPages,
                  'page'        => 1,
                  'limit'       =>$limit,
                  'total'       =>$total
                  ));           
       }

    }

    /**
     *
     * return the item's view at management side
     */

    public function managementItemViewAction($id, request $request){

     
        $response = new Response(); 


        try {

            $em = $this->getDoctrine()->getManager();                       
            $item=$em->getRepository('VanoFashionEShoppingBundle:Item')->getItem($id);
            if (!$item) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                if ($request->isXmlHttpRequest()) {
                    # code...
                    $array_item=$item->toArray();
                    return new JsonResponse($array_item);

                }

                
                return $this->render('VanoFashionEShoppingBundle:Item:managementItemView.html.twig',
                    array(
                          'item' => $item,                          
                          'returnPage'        => $request->query->get('returnPage'),
                          'limit'       =>$request->query->get('limit'), 
                          'mainImage'   =>$item->getMainImage()                     
                          ));
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }


    }
    
    /**
     *return the view for the editing of item
     *
     */
    public function itemEditAction( $id, Request $request)
    {

      $response = new Response(); 


        try {

            $em = $this->getDoctrine()->getManager();                       
            $item=$em->getRepository('VanoFashionEShoppingBundle:Item')->getItem($id);
            if (!$item) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

              $form = $this->createForm(ItemEditType::class, $item);

              if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                try {

                  $item->setUpdatedAt(new \Datetime());
                  $em->flush();

                  $this->get('session')->getFlashBag()->add('success', 'Item has been modified !');

                  return $this->redirectToRoute('vano_fashion_e_shopping_website_management_item_list');
                  
                } catch (UniqueConstraintViolationException $e) {

                  $this->get('session')->getFlashBag()->add('info', $e->getMessage());
                  return $this->render('VanoFashionEShoppingBundle:Item:itemEdit.html.twig', array(
                'form' => $form->createView()));
                  
                }
              }

              return $this->render('VanoFashionEShoppingBundle:Item:itemEdit.html.twig', array(
                'form' => $form->createView()));

               
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }

    }
    
    /**
     * delete an item
     *
     */
    public function itemDeleteAction( $id)
    {

      $response = new Response(); 

        try {

            $em = $this->getDoctrine()->getManager();                       
            $item=$em->getRepository('VanoFashionEShoppingBundle:Item')->find($id);
            if (!$item) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $em->remove($item);
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
     * return a product
     */

    public function getItemProductAction($id){

        try {

            $em = $this->getDoctrine()->getManager();                       
            $product=$em->getRepository('VanoFashionEShoppingBundle:ItemProduct')->find($id);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $array_product=$product->toArray();
                 return new JsonResponse($array_product);
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }

    }
    
    /**
     *return the view for the editing of item product
     *
     */
    public function itemProductEditAction($id, Request $request)
    {

       try {

            $em = $this->getDoctrine()->getManager();                       
            $product=$em->getRepository('VanoFashionEShoppingBundle:ItemProduct')->find($id);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

              $form = $this->createForm(ItemProductType::class, $product);

              if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                try {

                   $product->setUpdatedAt(new \Datetime());
                   $em->flush();

                   $this->get('session')->getFlashBag()->add('success', 'The item product has been modified successfully !');
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
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }


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

      if($request->isXmlHttpRequest()) {
        # code ajax request
        $array_products=array();
        $products= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemProduct')
        ->findAll();

        foreach ($products as $product) {
          # code...
          $array_products[]=$product->toArray();
        }
        
        return new JsonResponse($array_products);

      }
      # code if is not an ajax request
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
     * return a catgegory
     */

    public function getItemCategoryAction($id){

       $response = new Response();

        try {

            $em = $this->getDoctrine()->getManager();                       
            $category=$em->getRepository('VanoFashionEShoppingBundle:ItemCategory')->getCategory($id);
            if (!$category) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{

                $array_category=$category->toArray();
                 return new JsonResponse($array_category);
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }

    }
    
    /**
     *return the view for the editing of item category
     *
     */
    public function itemCategoryEditAction( $id, Request $request)
    {

       $response = new Response();

        try {

            $em = $this->getDoctrine()->getManager();                       
            $category=$em->getRepository('VanoFashionEShoppingBundle:ItemCategory')->getCategory($id);
            if (!$category) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            else{


              $form = $this->createForm(ItemCategoryType::class, $category);

              if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
               
                try {
                  $category->setUpdatedAt(new \Datetime());                  
                  $em->flush();  
                
                  $this->get('session')->getFlashBag()->add('success', 'The item category has been modified successfully!');
                  return $this->redirectToRoute('vano_fashion_e_shopping_website_management_itemcategory_list');
                    
                } catch (UniqueConstraintViolationException $e) {

                  $this->get('session')->getFlashBag()->add('info', 'This category already exists in database !');
                  return $this->render('VanoFashionEShoppingBundle:Item:itemCategoryEdit.html.twig', array(
                'form' => $form->createView()));
                    
                }
                

                
              }

              return $this->render('VanoFashionEShoppingBundle:Item:itemCategoryEdit.html.twig', array(
                'form' => $form->createView()));

                
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }



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

      if($request->isXmlHttpRequest()) {
        # code ajax request
        $array_categories=array();
        $categories= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemCategory')
        ->findAll();

        foreach ($categories as $category) {
          # code...
          $array_categories[]=$category->toArray();
        }
        
        return new JsonResponse($array_categories);

      }
      # code if is not an ajax request
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
              
                $this->get('session')->getFlashBag()->add('success', 'The item gender has been registered successfully!');
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
    public function itemGenderEditAction( $id, Request $request)
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

              $form = $this->createForm(ItemGenderType::class, $gender);
              if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

                try {

                  $gender->setUpdatedAt(new \Datetime());
                  $em->flush();

                  $this->get('session')->getFlashBag()->add('success', 'The item gender has been modified successfully!');
                  return $this->redirectToRoute('vano_fashion_e_shopping_website_management_itemgender_list');
              
                  
                } catch (UniqueConstraintViolationException $e) {

                  $this->get('session')->getFlashBag()->add('info', 'This gender already exists in database !');
                  return $this->render('VanoFashionEShoppingBundle:Item:itemGenderEdit.html.twig', array(
                'form' => $form->createView()));
              
               }


              }

              return $this->render('VanoFashionEShoppingBundle:Item:itemGenderEdit.html.twig', array(
          'form' => $form->createView()));

                
            }
            
        } catch (NotFoundHttpException $e) {

            $response->setContent("The resource has not been found");    
            $response->setStatusCode(Response::HTTP_NOT_FOUND);    
            return $response;        
        }
        

    }
    
    /**
     * delete an item gender
     *
     */
    public function itemGenderDeleteAction( $id)
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


      if($request->isXmlHttpRequest()) {
        # code ajax request
        $array_genders=array();
        $genders= $this->getDoctrine()
        ->getManager()
        ->getRepository('VanoFashionEShoppingBundle:ItemGender')
        ->findAll();

        foreach ($genders as $gender) {
          # code...
          $array_genders[]=$gender->toArray();
        }
        
        return new JsonResponse($array_genders);

      }

      # code if is not an ajax request

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


  /**
   *
   *this function display all pages about men shopping
   *
   *
   **/
  public function menShopAction( $_locale, Request $request){
    
    $category="";
    $selectedProduct="";
    $menProducts=null;
    $items=null;
    $designers= array( );
    $colors=array( );
    $selectedDesigners= array( );
    $selectedColors=array( );
    $requestedPrices=array( );
    $MinPrice=null;
    $MaxPrice=null;
    $itemFilter=array('gender' => array('men','unisex'));
    
    // get products of the category
    if($request->query->get('dept')) {
      $category=$request->query->get('dept');
      
      $menProducts= $this->getDoctrine()
      ->getManager()
      ->getRepository('VanoFashionEShoppingBundle:ItemProduct')
      ->getAllProducts( array('gender' => array('men','unisex'), 'category'=>array(''.$category)));
    }

    $limit=$this->getParameter('nber_items_per_page');
    
    // get items' product
    if($request->query->get('product')) {
      $selectedProduct=$request->query->get('product'); 
      $itemFilter['product']=array(''.$selectedProduct);       
    }
    // get items' category
    elseif ($menProducts!==null) {
      $productNames=array();

      foreach ($menProducts as $product) {
        # code...
        $productNames[]=$product->getName();
      }

      $itemFilter['product']=$productNames;
      
    }

    // get items of selected designers
    if($request->query->get('designers')) {
      $selectedDesigners=explode(',',$request->query->get('designers')); 
      $itemFilter['brand']=$selectedDesigners;       
    }

    // get items of selected designers
    if($request->query->get('color')) {
      $selectedColors=explode(',',$request->query->get('color')); 
      $itemFilter['color']=$selectedColors;       
    }

    // get items in between the selected price(s)
    if($request->query->get('price')) {
      $requestedPrices=explode('-',$request->query->get('price')); 
      $itemFilter['price']=$requestedPrices;       
    }

    $repository= $this->getDoctrine()
                    ->getManager()
                    ->getRepository('VanoFashionEShoppingBundle:Item');
    $items=$repository->getItems( 1,$limit,$itemFilter);


    // collect colors and brands' items
    $menItems=$repository->getItems( 0,0,array('gender' => array('men','unisex')));

    foreach ($menItems as $item) {
      # code...
      if(!in_array($item->getBrand(), $designers )){
        $designers[]=$item->getBrand();
      }

      if(!in_array($item->getColor(),$colors )){
        $colors[]=$item->getColor();
      }
    }

    $page=($request->query->get('page'))? $request->query->get('page') : 1 ;
    $total=count($items);
    $nbPages = ceil($total / $limit);

    
    if ($nbPages>0 and $page > $nbPages) {

      throw $this->createNotFoundException("page does'nt exist!");

    }




    return $this->render('VanoFashionEShoppingBundle:Item:shop.html.twig',
      array(
        'category'=> $category,
        'selectedProduct' => $selectedProduct,
        'selectedDesigners' => $selectedDesigners,
        'selectedColors' => $selectedColors,
        'products' => $menProducts,
        'items'    => $items,
        'designers'    => $designers,
        'colors'    => $colors,
        'price'     => $requestedPrices,
        'page' => $page,
        'nbPages' => $nbPages)
        );

  }





}
