<?php

/**
 * Router - Gère toutes les routes de l'application
 */
class Router
{
/**
 *Stocke toutes les routes
 * Format: ['GET'=> ['/home' => ['controller' =>...,'method' =>...]], 'POST'=>[...]]   
 */
 private array $routes = [];

 /**
     * Enregistre une nouvelle route GET
     * 
     * @param string $path Le chemin de l'URL (ex: '/contact')
     * @param string $controller Le nom du contrôleur (ex: 'PageController')
     * @param string $method La méthode à appeler (ex: 'contact')
     * 
     * Exemple d'utilisation:
     * $router->get('/contact', 'PageController', 'contact');
     */
    public function get(string $path, string $controller, string $method): void{
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Enregistre une nouvelle route POST
     * 
     * @param string $path Le chemin de l'URL
     * @param string $controller Le nom du contrôleur
     * @param string $method La méthode à appeler
     * 
     * POST est utilisé pour envoyer des données (formulaires, etc.)
     */
    public function post(string $path, string $controller, string $method): void{
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch(): void{
        // Récupère la méthode HTTP (GET, POST, etc..)
        $method = $_SERVER['REQUEST_METHOD'];

        // Récupère le chemin de l'URL
        // parse_url() : analyse une URL et retourne ses composants
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Nettoie le chemin (supprime les barres obliques en trop)
        $path = trim($path, '/');

        // Si le chemin est vide, on redirige vers la page d'accueil
        if (empty($path)) {
            $path = '/';
        }else{
            $path = '/' . $path;
        }

       
        if (!isset($this->routes[$method][$path])) {
            $this->notFound();
            return;
        }
           
        // Récupère la route correspondante
        $route = $this->routes[$method][$path];
        $controllerName = 'App\\Controllers\\'.$route['controller'];
        $methodName = $route['method'];
        
        if (!class_exists($controller)){
            die("Le contrôleur " . $controller . " n'existe pas.");
        }

        $controller = new $controllerName();
        if (!method_exists($controller, $methodName)){
            die("La méthode " . $methodName . " n'existe pas dans le contrôleur " . $controllerName . ".");
        }

        $controller->$methodName();

       

       
    }
    private function notFound(): void{
            http_response_code(404);
            echo "<h1>404 - Page non trouvée</h1>";
            echo "<p>La page que vous cherchez n'existe pas.</p>";
        }

        /**
         * Affiche toutes les routes (utile pour le debug)
         */
        public function dumpRoutes(): void{
            echo "<pre>";
            print_r($this->routes);
            echo "</pre>";
        }

}