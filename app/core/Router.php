<?php
namespace App\Core;

class Router
{
    private $routes = [];
    private $params = [];

    public function add($method, $route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9_\-]+)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[] = ['method' => strtoupper($method), 'route' => $route, 'params' => $params];
    }

    public function match($url, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['route'], $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) $this->params[$key] = $match;
                }
                $this->params = array_merge($this->params, $route['params']);
                return true;
            }
        }
        return false;
    }

    public function getParams() { return $this->params; }

    public function dispatch($url, $method)
    {
        $url = $this->removeQueryString($url);
        if ($this->match($url, $method)) {
            $controller = $this->params['controller'] ?? 'Home';
            $controllerClass = strpos($controller, '\\') !== false
                ? "App\\Controllers\\{$controller}Controller"
                : "App\\Controllers\\" . $this->convertToStudlyCaps($controller) . "Controller";

            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass($this->params);
                $action = $this->convertToCamelCase($this->params['action'] ?? 'index');
                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method {$action} not found", 404);
                }
            } else {
                throw new \Exception("Controller not found", 404);
            }
        } else {
            throw new \Exception("Page not found", 404);
        }
    }

    private function removeQueryString($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) $url = $parts[0];
            else $url = '';
        }
        return $url;
    }

    private function convertToStudlyCaps($s) { return str_replace(' ', '', ucwords(str_replace('-', ' ', $s))); }
    private function convertToCamelCase($s) { return lcfirst($this->convertToStudlyCaps($s)); }
}
