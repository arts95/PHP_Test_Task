<?php
/**
 * Created by PhpStorm.
 * User: arsenii
 * Date: 07.02.18
 * Time: 20:15
 */

namespace controller;


use service\Request;
use service\Response;

abstract class BaseController
{
    protected $method = '';
    protected $args = [];
    protected $file = null;

    public function __construct()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == Request::METHOD_POST && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == Request::METHOD_DELETE) {
                $this->method = Request::METHOD_DELETE;
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == Request::METHOD_PUT) {
                $this->method = Request::METHOD_PUT;
            } else {
                throw new \Exception("Unexpected Header");
            }
        }
    }

    public function post()
    {
        if ($this->method == Request::METHOD_PUT || $this->method == Request::METHOD_PATCH) {
            parse_str(file_get_contents("php://input"), $_POST);
        }
        return $_POST;
    }

    public function get()
    {
        return $_GET;
    }

    public function setResponse($data, $status = Response::HTTP_OK)
    {
        header("HTTP/1.1 " . $status . " " . Response::$statusTexts[$status]);
        $response['status'] = $status;
        $response['code'] = Response::$statusTexts[$status] ?? Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return json_encode($response, JSON_PRETTY_PRINT);
    }

    public function redirect($action)
    {
        header("Location: {$action}", true, 301);
        return json_encode([], JSON_PRETTY_PRINT);

    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}