<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 4:56 PM
 */

namespace ClickAndBoat\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Homepage
 * @package ClickAndBoat\Controllers
 */
class Homepage
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Homepage constructor.
     * @param Request $request
     * @param Response $response
     * @param \Twig_Environment $twig
     */
    public function __construct(Request $request, Response $response, \Twig_Environment $twig)
    {
        $this->request = $request;
        $this->response = $response;
        $this->twig = $twig;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show()
    {
        $this->response->setContent($this->twig->render('index.html.twig'));
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->send();
    }

}