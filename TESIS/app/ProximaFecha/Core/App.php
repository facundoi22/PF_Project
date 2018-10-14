<?php
namespace ProximaFecha\Core;


/**
 * Class App
 * @package ProximaFecha\Core
 */
class App
{
    public static $baseFolder;
    public static $appFolder;
    public static $publicFolder;
    public static $viewsFolder;

    /** @var Request */
    protected $request;
    protected $controller;
    protected $action;

    /**
     * App constructor.
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        self::$baseFolder = $baseUrl;
        self::$appFolder = $baseUrl . "/app";
        self::$publicFolder = $baseUrl . "/public";
        self::$viewsFolder = $baseUrl . "/views";
    }

    /**
     * Arranca la aplicación.
     *
     * @throws \InvalidURLException
     */
    public function run()
    {
        $this->request = new Request;
        $this->parseRoute();
    }

    /**
     * @throws InvalidURLException
     */
    public function parseRoute()
    {
        if(Route::routeExists($this->request->getMethod(), $this->request->getRoute())) {
            $action = Route::getAction($this->request->getMethod(), $this->request->getRoute());
              list($this->controller, $this->action) = explode('@', $action);

            $this->controller = 'ProximaFecha\\Controller\\' . $this->controller;
            $controller = new $this->controller;
            $controller->{$this->action}($this->request);
        } else {
            header("Location: ../public");
        }
    }
}