<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 07.02.18
 */

namespace app;

use controller\DefaultController;
use service\Request;
use service\Response;

class Application
{
    public function handle()
    {
        /** @todo write tests for app */
        $requestString = ltrim($_SERVER['REQUEST_URI'], '/');
        $urlParams = explode('/', $requestString);
        $controllerName = "controller\\" . ucfirst(array_shift($urlParams)) . 'Controller';
        $id = null;
        $actionName = '';
        if (isset($urlParams[0])) {
            if ($urlParams[0] === strval(intval($urlParams[0]))) {
                $id = (int)$urlParams[0];
            }
        }
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case Request::METHOD_GET:
                    if (is_int($id)) {
                        $actionName = 'detail';
                    } else {
                        $actionName = 'list';
                    }
                    break;
                case Request::METHOD_POST:
                    $actionName = 'create';
                    if (is_int($id)) {
                        throw new \Exception(Response::$statusTexts[Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                    }
                    break;
                case Request::METHOD_PATCH:
                case Request::METHOD_PUT:
                    if (is_int($id)) {
                        $actionName = 'update';
                    }
                    break;
                case Request::METHOD_DELETE:
                    if (is_int($id)) {
                        $actionName = 'delete';
                    }
                    break;
            }

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $actionName)) {
                    switch ($actionName) {
                        case 'delete':
                        case 'detail':
                        case 'update':
                            echo $controller->$actionName($id);
                            break;
                        case 'create':
                        case 'list':
                            echo $controller->$actionName();
                            break;
                        default:
                            throw new \Exception();
                    }
                } else {
                    throw new \Exception();
                }
            } else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            echo (new DefaultController())->defaultAction($e->getCode());
        }
    }
}