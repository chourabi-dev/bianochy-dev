<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\DirectMessage;
use App\Entity\Ingredient;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; 
use Symfony\UX\Chartjs\Model\Chart;

use EasyCorp\Bundle\EasyAdminBundle\Dto\LocaleDto;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        
    ) {
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         

        return $this->render('admin/index.html.twig', [
            
        ]);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        
            ->setTitle('ACME Corp.') 
            ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>') 
            ->setFaviconPath('favicon.svg') 
            ->setTranslationDomain('my-custom-domain') 
            ->setTextDirection('ltr') 
            ->renderContentMaximized() 
            //->renderSidebarMinimized() 
            ->disableDarkMode() 
            ->setDefaultColorScheme('dark') 
            ->generateRelativeUrls() 
            ->setLocales(['en', 'fr']) 
            ->setLocales([
                'en' => '🇬🇧 English',
                'fr' => 'FR French'
            ]) 
            ->setLocales([ 
                Locale::new('en', 'English', 'far fa-language') ,
                Locale::new('fr', 'french', 'far fa-language') 
                
            ])
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de board', 'fa fa-home');
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Inobx', 'fas fa-list', DirectMessage::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-list', Product::class);
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-list', Ingredient::class);
        
        
        
    }
}
