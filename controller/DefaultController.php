<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 08.02.18
 */

namespace controller;


use service\Response;

class DefaultController extends BaseController
{
    public function defaultAction(?string $status = null)
    {
        return $this->setResponse([], $status ?: Response::HTTP_NOT_FOUND);
    }
}