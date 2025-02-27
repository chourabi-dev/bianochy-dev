<?php

namespace App\Controller\Admin;

use App\Entity\Banner;
use App\Entity\Category;
use App\Entity\DirectMessage;
use App\Entity\CheckoutRequest;
use App\Entity\Image;
use App\Entity\Ingredient;
use App\Entity\PaymentStatus;
use App\Entity\Perfum;
use App\Entity\Product;
use App\Entity\ProductsPack;
use App\Entity\Promotion;
use App\Entity\SubCategory;
use App\Repository\CheckoutRequestRepository;
use App\Repository\PaymentStatusRepository;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; 
 
use EasyCorp\Bundle\EasyAdminBundle\Dto\LocaleDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;  
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{ 

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine )
    {
        $this->doctrine = $doctrine;
        
    }


    #[Route('/{_locale}/admin', name: 'admin', requirements: [ 'requirements' => 'en|fr' ])]
    public function index(  ): Response
    {
        $repository = $this->doctrine->getRepository(DirectMessage::class);
        $items = $repository->findAll();

        $requestRepo = $this->doctrine->getRepository(CheckoutRequest::class);
        $commandes = $requestRepo->findAll();

        $galleryRepo = $this->doctrine->getRepository(Image::class);
        $images = $requestRepo->findAll();

        $data = [];
        foreach ($commandes as $key => $c) {
            if ($c->getPaymentStatus() != null) {
                array_push($data,$c);
            }
        }


        return $this->render('admin/index.html.twig', [
            'commandes'=>$commandes,
            'commandesTreated'=>$data,
            'inbox'=>$items,
            'images'=>$images
        ]);
    }


    public function configureDashboard(): Dashboard
    {
         
       
        return Dashboard::new()
            
            ->setTitle('Sentalia') 
            ->setTitle('<img src="/sentalia.svg" width="150px" style="display:block;margin:auto;">') 
            ->setFaviconPath('sentalia.svg')  
            ->setTextDirection('ltr') 
            ->renderContentMaximized()  
            ->disableDarkMode( false ) 
            ->setDefaultColorScheme('dark') 
            ->generateRelativeUrls()  
            ->setLocales([ 
                Locale::new('fr', 'français', 'fa fa-globe') ,
                Locale::new('en', 'English', 'fa fa-globe')  
            ])
             
            
        ;
    }

    public function configureMenuItems(): iterable
    {
        

        $repository = $this->doctrine->getRepository(DirectMessage::class);
        $items = $repository->findAll();

        $requestRepo = $this->doctrine->getRepository(CheckoutRequest::class);
        $commandes = $requestRepo->findBy(['paymentStatus'=> null ]);

        

        
        yield MenuItem::linkToDashboard('menu.dashboard', 'fa fa-home'); 
        
        if( sizeof($commandes) != 0 ){
            yield MenuItem::linkToRoute('menu.requests', 'fa fa-shopping-cart','web_master_requests')->setBadge( sizeof($commandes) ); 
        
        }else{
            yield MenuItem::linkToRoute('menu.requests', 'fa fa-shopping-cart','web_master_requests'); 
        
        }
        

        yield MenuItem::linkToCrud('menu.products', 'fa fa-database', Product::class);
        yield MenuItem::linkToCrud('menu.promotions', 'fa fa-gift', Promotion::class);
        yield MenuItem::linkToCrud('menu.banner', 'fa fa-image', Banner::class);
        
        
        yield MenuItem::linkToCrud('menu.products_pack', 'fa fa-database', ProductsPack::class); 
        yield MenuItem::linkToCrud('menu.inbox', 'fa fa-envelope', DirectMessage::class)->setBadge( sizeof($items) ); 
        yield MenuItem::subMenu('menu.options', 'fas fa-cogs')->setSubItems([
            MenuItem::linkToCrud('menu.categories', 'fas fa-list', Category::class),
            MenuItem::linkToCrud('menu.sub_categories', 'fas fa-list', SubCategory::class), 
            MenuItem::linkToCrud('menu.ingredients', 'fas fa-list', Ingredient::class),
            MenuItem::linkToCrud('menu.perfum', 'fas fa-list', Perfum::class),
            MenuItem::linkToCrud('menu.payment_status', 'fa fa-money', PaymentStatus::class),
            
            MenuItem::linkToCrud('menu.gallery', 'fa fa-image', Image::class),
            
            
            
        ]);
        
        
    }


   
    #[Route('/web_master_requests', name: 'web_master_requests')]
    public function web_master_requests( CheckoutRequestRepository $repo, PaymentStatusRepository $paymentStatusRepository ): Response
    { 

        return $this->render('admin/commandes.html.twig', [
            'commandes'=>$repo->findAll(),
            'payments_status'=>$paymentStatusRepository->findAll()
        ]);
    }



    #[Route('/check_bon_commandes/{id}', name: 'check_bon_commandes')]
    public function check_bon_commandes(PromotionRepository $promotionRepository, CheckoutRequest $entity , PaymentStatusRepository $paymentStatusRepository ): Response
    { 

        $promotions = $promotionRepository->findBy(['isPachIncluded'=>true],['id' => 'DESC'] );

        $promo = null;

        if (!empty($promotions)) {
            $tmp = $promotions[0];
        
            if ($tmp !=  null) {
                $promo = $tmp;
            }
        }

        return $this->render('admin/bon-de-commandes.html.twig', [
            'commande'=>$entity,
            'promo'=>$promo
        ]);
    }


    #[Route('/update/order', name: 'update_order_route')]
    public function update_order_route(Request $request, EntityManagerInterface $em, PaymentStatusRepository $paymentStatusRepository, CheckoutRequestRepository $repo ): Response
    { 
        $checkoutRequest = null;
        $id = $request->request->get('id');
        $status_id = $request->request->get('state');

        $checkoutRequest = $repo->findOneBy(['id'=>$id]);
        $paymentStatus = $paymentStatusRepository->findOneBy(['id'=>$status_id]);

        $checkoutRequest->setPaymentStatus($paymentStatus);

        $em->persist($checkoutRequest);
        $em->flush();
        

        return $this->json(['success'=>true , $request->request]);
    }
}

