<?php
namespace ProximaFecha\Core;

/**
 * Class Route
 *
 * Se encarga del manejo de las rutas.
 *
 * @package ProximaFecha\Core
 */
class Route
{
    /**
     * @var array   Almacena todas las rutas, según su verbo.
     */
    public static $routes = [
        'GET'       => [],
        'POST'      => [],
        'PUT'       => [],
        'DELETE'    => [],
    ];

    /**
     * Contiene los parámetros de la route (los valores
     * entre {}).
     *
     * Formato:
     * /peliculas/{id}
     *
     * $routeParams = ['id' => 1]
     *
     * @var array
     */
    protected static $routeParams = [];

    /**
     * Registra una ruta en la aplicación.
     *
     * @param string $method    El verbo HTTP.
     * @param string $url       La ruta virtual.
     * @param string $action    La acción a realizar.
     */
    public static function addRoute($method, $url, $action)
    {
        $method = strtoupper($method);
        self::$routes[$method][$url] = $action;
    }

    /**
     * Indica si la ruta existe.
     *
     * @param string $method
     * @param string $requestedRoute
     * @return bool
     */
    public static function routeExists($method, $requestedRoute)
    {
        foreach (self::$routes[$method] as $routeName => $actionName) {
            if($routeName === $requestedRoute) {
                return true;
            }

            if(self::parameterizedRouteExists($routeName, $requestedRoute)) {
                return true;
            }
        }

        return false;

    }

    /**
     * Retorna si la $requestedRoute matchea con el $routeName
     * parametrizado (que incluye {}).
     *
     * @param $routeName
     * @param $requestedRoute
     * @return bool
     */
    public static function parameterizedRouteExists($routeName, $requestedRoute)
    {
        $routeNameData = explode('/', $routeName);
        $requestedRouteData = explode('/', $requestedRoute);

        // Verificamos si la cantidad de partes de las rutas
        // es igual.
        if(count($routeNameData) == count($requestedRouteData)) {
            $routeMatch = true;
            for($i = 0, $length = count($routeNameData); $i < $length; $i++) {
                if($routeNameData[$i] != $requestedRouteData[$i]) {
                    if(strpos($routeNameData[$i], '{') === false) {
                        $routeMatch = false;
                    } else {
                        $paramName = substr($routeNameData[$i], 1, -1);
                        self::$routeParams[$paramName] = $requestedRouteData[$i];
                    }
                }
            }
            return $routeMatch;
        }

        return false;
    }

    /**
     * Retorna la acción para la ruta.
     *
     * @param $method
     * @param $requestedRoute
     * @return mixed
     */
    public static function getAction($method, $requestedRoute)
    {
        foreach (self::$routes[$method] as $routeName => $actionName) {
            if($routeName === $requestedRoute) {
                return $actionName;
            }
            if(self::parameterizedRouteExists($routeName, $requestedRoute)) {
                return $actionName;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public static function getRouteParams()
    {
        return self::$routeParams;
    }
}