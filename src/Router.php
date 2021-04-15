<?php


namespace Meast\Router;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Route[] $routes All routes of the app
     */
    private array $routes = [];

    /**
     * @var string $url Actual URL in the navigator
     */
    private string $url;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct (Request $request)
    {
        $this->request = $request;
        $this->url = $request->getRequestUri();
    }

    /**
     * @param string $path URL of the route
     * @param string $name Name of the route (for generating url)
     * @var mixed $callback Method to call when a route matched (For use other method in class, you can use `Class@method`)
     */
    public function get (string $path, string $name, $callback): Route
    {
        $route = new Route($path, $name, $callback);
        $this->routes['GET'][] = $route;
        return $route;
    }

    /**
     * Launch the match system for the actual url
     */
    public function run ()
    {
        /** @var Route $route */
        foreach ($this->routes[$this->request->getMethod()] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }

        throw new RouteNotFoundException("No route found for $this->url");
    }

}