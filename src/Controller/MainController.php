<?php

namespace App\Controller;

use App\Entity\CheckoutRelatedProduct;
use App\Entity\CheckoutRelatedProductPack;
use App\Entity\CheckoutRequest;
use App\Entity\DirectMessage;
use App\Entity\DirectMessge;
use App\Entity\Perfum;
use App\Entity\Product;
use App\Entity\ProductReview;
use App\Entity\ProductsPack;
use App\Entity\SubCategory;
use App\Form\CheckoutFormType;
use App\Form\DirectMessageType;
use App\Repository\BannerRepository;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\PerfumRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductsPackRepository;
use App\Repository\PromotionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class MainController extends AbstractController{
    #[Route('/', name: 'app_main')]
    public function index( BannerRepository $bannerRepository, PromotionRepository $promotionRepository,  CategoryRepository $categoryRepository,ImageRepository $imageRepository, PerfumRepository $perfumRepository, ProductRepository $productRepository): Response
    {
        $promotions = $promotionRepository->findAll();
        $pormo = end($promotions);


        return $this->render('main/index.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'products'=>$productRepository->findAll(),
            'latests'=>$productRepository->findBy([], ['id' => 'DESC'], 4),
            'perfums'=>$perfumRepository->findAll(),
            'images'=>$imageRepository->findAll(),
            'promotion'=>$pormo,
            'banners'=>$bannerRepository->findAll()
             
             
        ]);
    }


    #[Route('/checkout', name: 'checkout_route')]
    public function checkout_route(Request $request,ProductRepository $productRepository, ProductsPackRepository $productPackRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {

        $task = new CheckoutRequest();

         

        if ( $request->getMethod() == 'POST' ) { 
            $task->setCreatedAt(new DateTime('now'));
            $body = $request->request;

 
            $productsJson = $request->get('products');
            $packsJson = $request->get('packs');
            $lastname = $request->get('lastname');
            $firstname = $request->get('firstname');
            $email = $request->get('email');
            $phone = $request->get('phone');
            $address = $request->get('address');
    
            // Decode JSON parameters
            $products = json_decode($productsJson, true);
            $packs = json_decode($packsJson, true);
    
              

             $task->setFirstname($firstname);
             $task->setLastname($lastname);
             $task->setEmail($email);
             $task->setPhone($phone);
             $task->setAddress($address);

             // save task
             $entityManager->persist($task);
            

             // loop throo products
             if ($products != null) {
                foreach ($products as $product) {
                    $p = $productRepository->findOneBy(['id'=>$product['id']]);
    
                    $entity = new CheckoutRelatedProduct();
                    $entity->setProduct($p);
                    $entity->setQuantity($product['quantity']);
                    $entity->setRequest($task);
                    $entityManager->persist($entity); 
                 }
             }


             if ($packs != null) {
                foreach ($packs as $pack) {
                    $p = $productPackRepository->findOneBy(['id'=>$pack['id']]);
    
                    $entity = new CheckoutRelatedProductPack();
                    $entity->setPack($p);
                    $entity->setQuantity($pack['quantity']);
                    $entity->setRequest($task);
                    $entityManager->persist($entity); 
                 }
    
             }
             $entityManager->flush();




            $this->addFlash('success', 'Votre commande a été envoyée avec succès'); 
            return $this->redirectToRoute('app_main');
        }


        return $this->render('main/checkout.html.twig', [
            'categories'=>$categoryRepository->findAll()
             
        ]);
    }


    #[Route('/contact-us', name: 'contact_us_route')]
    public function contact_us_route(Request $request,EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        // generate form
        $task = new DirectMessage();

        $form = $this->createForm(DirectMessageType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $task->setCreatedAt(new DateTime('now'));
            $task = $form->getData(); 
            $entityManager->persist($task);
            $entityManager->flush();
            // flush success message FR
            $this->addFlash('success', 'Votre message a été envoyé avec succès'); 

            return $this->redirectToRoute('contact_us_route');
        }

        return $this->render('main/contact-us.html.twig', [
            'categories'=>$categoryRepository->findAll(),
             'form'=>$form->createView()
        ]);
    }


    


    #[Route('/collections/{id}', name: 'collections_route')]
    public function collections_route(CategoryRepository $categoryRepository,SubCategory $subCategory): Response
    {
        return $this->render('main/category-explore.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'subCategory'=>$subCategory 
        ]);
    }



    #[Route('/collections/perfum/{id}', name: 'collections_perfum_route')]
    public function collections_perfum_route(CategoryRepository $categoryRepository,Perfum $perfum): Response
    {
        return $this->render('main/perfum-explore.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'perfum'=>$perfum 
        ]);
    }



    #[Route('/collections/packs/discover', name: 'packs_route')]
    public function packs_route(PromotionRepository $promotionRepository, ProductsPackRepository $productsPackRepository, CategoryRepository $categoryRepository ): Response
    {
        
        $promotions = $promotionRepository->findBy(['isPachIncluded'=>true],['id' => 'DESC'] );

        $promo = null;

        if (!empty($promotions)) {
            $tmp = $promotions[0];
        
            if ($tmp !=  null) {
                $promo = $tmp;
            }
        }


        


        


        return $this->render('main/packs-listings.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'packs'=>$productsPackRepository->findAll(), 
            'promo'=>$promo
        ]);
    }

    #[Route('/collections/packs/discover/details/{id}', name: 'product_pack_details_route')]
    public function product_pack_details_route( PromotionRepository $promotionRepository, ProductsPack $productsPack, CategoryRepository $categoryRepository ): Response
    {

        $promotions = $promotionRepository->findBy(['isPachIncluded'=>true],['id' => 'DESC'] );

        $promo = null;

        if (!empty($promotions)) {
            $tmp = $promotions[0];
        
            if ($tmp !=  null) {
                $promo = $tmp;
            }
        }


        return $this->render('main/packs-details.html.twig', [
            'categories'=>$categoryRepository->findAll(),
            'pack'=>$productsPack,
            'promo'=>$promo
        ]);
    }


    


    #[Route('/collections/product-details/{id}', name: 'product_details_route')]
    public function product_details_route(Request $request,EntityManagerInterface $entityManagerInterface, CsrfTokenManagerInterface $csrfTokenManage, CategoryRepository $categoryRepository, Product $product): Response
    {
         

        if( $request->getMethod() == 'POST' ){
            $body = $request->request;
            //  csrf check
            $submittedToken = $request->request->get('_csrf_token');

            if ($this->isCsrfTokenValid('new_review', $submittedToken) == false) {
                $this->addFlash('erreur', "Une erreur s'est produite, veuillez réessayer plus tard");
                return $this->redirectToRoute('product_details_route', ['id'=>$product->getCategory()->getId()]);
               
            }else{
                $review = new ProductReview();
                $review->setProduct($product);
                $review->setNote($body->get('note'));
                $review->setTitle($body->get('title'));
                $review->setReview($body->get('review'));
                $review->setFullname($body->get('fullname'));
                $review->setEmail($body->get('email'));

                $entityManagerInterface->persist($review);
                $entityManagerInterface->flush();

                // flush success message FR
                $this->addFlash('success', 'Votre avis a été envoyé avec succès');
                return $this->redirectToRoute('product_details_route', ['id'=>$product->getId()]);
                
                

            }

        }



        return $this->render('main/product-details.html.twig', [
            'product'=>$product,
            'categories'=>$categoryRepository->findAll(),
        ]);
    }



    #[Route('/API/ADD-PRODUCT-TO-CART/{id}', name: 'add_product_to_cart_route')]
    public function add_product_to_cart_route(Request $request,Product $product, SessionInterface $sessionInterface): Response
    {
        /*
        
            <input type="hidden" class="form-control" name="product_id" value="{{product.id}}">
            <!--csrf-->
            <input type="hidden" name="csrf_token" value="{{ csrf_token('product'~product.id) }}">
             */

             if( $request->getMethod() == 'POST' ){
                
                //  csrf check
                $submittedToken = $request->request->get('_csrf_token');
    
                if ($this->isCsrfTokenValid('product'.$product->getId(), $submittedToken)) {
                    
                    // save in session
                    $sessionInterface->set('product_id',$product->getId());
                    // flush success
                    $this->addFlash('success', 'Produit ajouté avec succès');
                    return $this->redirectToRoute('cart_route');

                }
             }

        
        return $this->redirectToRoute('app_main');
    }






    #[Route('/api/details/product/{id}', name: 'get_product_informations_route')]
    public function get_product_informations_route(Request $request,Product $product, SessionInterface $sessionInterface, EntityManagerInterface $em): Response
    {
        $price = 0;

        // check if product is in promotion


        $promotion = null;

        if ($product->getCategory() !== null) {
            $categoryPromotions = $product->getCategory()->getPromotions();
            $promotion = $categoryPromotions->last(); // Get the last element
        }

        if ($product->getSubCategory() !== null) {
            $subCategoryPromotions = $product->getSubCategory()->getPromotions();
            $promotion = $subCategoryPromotions->last(); // Override with last element from sub-category if available
        }

        $today = (new \DateTime())->format('Y-m-d'); // Today's date in "Y-m-d" format


        $price = $product->getPrice() ;
         
        if ($promotion !== null) {
            $startAt = $promotion->getStartAt()->format('Y-m-d');
            $endAt = $promotion->getEndAt()->format('Y-m-d');

            if ($startAt <= $today && $today <= $endAt) {
                $price = $product->getPrice()  - ( ( $product->getPrice() * $promotion->getValue() ) / 100 ) ;
         
            }
        }
            

       

        // title, imageUrl, price
        return $this->json([
            'title'=>$product->getLabel(),
            'imageUrl'=>'/uploads/products/'.$product->getImages()[0],
            'price'=>$price,
            
        ]);
    }


    #[Route('/api/details/pack/{id}', name: 'get_pack_informations_route')]
    public function get_pack_informations_route(PromotionRepository $promotionRepository, Request $request,ProductsPack $pack, SessionInterface $sessionInterface): Response
    { 
        $promotions = $promotionRepository->findBy(['isPachIncluded'=>true],['id' => 'DESC'] );

        $promo = null;

        if (!empty($promotions)) {
            $tmp = $promotions[0];
        
            if ($tmp !=  null) {
                $promo = $tmp;
            }
        }
        $price = $pack->getPrice();

        if( $promo != null ){
            $price  = $price -( ( $price * $promo->getValue() )  / 100 );  
        }

        // title, imageUrl, price
        return $this->json([
            'title'=>$pack->getTitle(),
            'imageUrl'=>'/uploads/packs/'.$pack->getPhoto(),
            'price'=>$price,
             
            
        ]);
    }


   







   
}
