<?php
namespace ProximaFecha\Core;

/**
 * Class Request
 * Se encarga de manejar la info de la petición.
 *
 * @package ProximaFecha\Core
 */
class Request
{
    /**
     * @var string  El método de la petición HTTP (GET, POST, PUT, DELETE).
     */
    protected $method;

    /**
     * @var string  La url completa de la petición
     *              Ej: http://localhost/santiago/sitio/public/peliculas
     */
    protected $requestedUrl;

    /**
     * @var string  La ruta pedida (a partir de la carpeta public).
     *              Ej: /peliculas
     */
    protected $route;

    /**
     * @var array   Los datos llegados por POST o PUT.
     */
    protected $data;

    protected $files ;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->requestedUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        $filename = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'];
        $filename = substr($filename, 0, strrpos($filename, '/'));

        $this->route = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
        $this->route = substr($this->route, strlen($filename));

        $this->parseData();
    }

    public function parseData()
    {
        $this->data = $_POST;
        $this->files = $_FILES;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRequestedUrl()
    {
        return $this->requestedUrl;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }
}