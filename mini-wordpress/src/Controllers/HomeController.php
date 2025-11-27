<?php
namespace App\Controllers;

use App\Core\Controller;
/**
 * HomeController - Gère la page d'accueil
 */
class HomeController extends Controller{
    /**
     * Affiche la page d'accueil
     */
    public function index(): void{
        $this->view('home',['title' => 'Bienvenue sur Mini Wordpress',
    'message' => 'Le système fonctionne!']);
    }
}