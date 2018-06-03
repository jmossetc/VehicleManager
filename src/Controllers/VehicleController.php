<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 8:19 PM
 */

namespace ClickAndBoat\Controllers;

use ClickAndBoat\Dependencies;
use ClickAndBoat\Models\Vehicles\Boat;
use ClickAndBoat\Models\Vehicles\Scooter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VehicleController
 * @package ClickAndBoat\Controllers
 */
class VehicleController
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
     * VehicleController constructor.
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
     * @param $vars
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showBoat($vars)
    {
        $id = (int)$vars['id'];
        $pdo = Dependencies::getPDODependency();


        /**
         * @var Boat
         */
        $boat = new Boat($pdo);

        if ($boat->mapFromDB($id)) {

            $content = $this->twig->render('showVehicle.html.twig', [
                'vehicle' => $boat,
                'vehicleType' => 'boat'
            ]);

            $this->response->setContent($content);
            $this->response->headers->set('Content-Type', 'text/html');
            $this->response->setStatusCode(200);
            $this->response->send();
        } else {
            $this->response->setContent('400 - Bad Request');
            $this->response->headers->set('Content-Type', 'text/plain');
            $this->response->setStatusCode(400);
            $this->response->send();
            return 0;
        }
    }

    /**
     * @param $vars
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showScooter($vars)
    {
        $id = (int)$vars['id'];

        $pdo = Dependencies::getPDODependency();


        /**
         * @var Boat
         */
        $scooter = new Scooter($pdo);

        $scooter->mapFromDB($id);
        if ($scooter->mapFromDB($id)) {

            $content = $this->twig->render('showVehicle.html.twig', [
                'vehicle' => $scooter,
                'vehicleType' => 'scooter'
            ]);

            $this->response->setContent($content);
            $this->response->headers->set('Content-Type', 'text/html');
            $this->response->setStatusCode(200);
            $this->response->send();
            return 0;
        } else {
            $this->response->setContent('400 - Bad Request');
            $this->response->headers->set('Content-Type', 'text/plain');
            $this->response->setStatusCode(400);
            $this->response->send();
            return 0;
        }
    }

    /**
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function createScooter()
    {
        $pdo = Dependencies::getPDODependency();

        if ($this->request->request->get('name') !== null) {
            $scooter = new Scooter($pdo);
            $scooter->setName($this->request->request->get('name'));
            $scooter->setType($this->request->request->get('type'));
            $scooter->setFuel($this->request->request->get('fuel'));
            $scooter->setFabricationYear((int)$this->request->request->get('fabrication_year'));
            $scooter->persist();
            $this->showScooter(['id' => $scooter->getId()]);
            return 0;
        }

        $content = $this->twig->render('createScooter.html.twig');
        $this->response->setContent($content);
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->send();
        return 0;
    }

    /**
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function createBoat()
    {
        $pdo = Dependencies::getPDODependency();

        if ($this->request->request->get('name') !== null) {
            $boat = new Boat($pdo);
            $boat->setName($this->request->request->get('name'));
            $boat->setType($this->request->request->get('type'));
            $boat->setFuel($this->request->request->get('fuel'));
            $boat->setFabricationYear((int)$this->request->request->get('fabrication_year'));
            $boat->persist();
            $this->showBoat(['id' => $boat->getId()]);
            return 0;
        }

        $content = $this->twig->render('createBoat.html.twig');
        $this->response->setContent($content);
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->send();
        return 0;
    }

    /**
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showBoats()
    {
        $pdo = Dependencies::getPDODependency();
        $filters = null;
        if ($this->request->request->get('name') !== null) {
            $filters = ['name' => $this->request->request->get('name')];
        }
        $boats = Boat::getAllEntries($pdo, $filters);

        $content = $this->twig->render('showVehicles.html.twig', [
            'vehicles' => $boats,
            'vehicleType' => 'boat'
        ]);

        $this->response->setContent($content);
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->send();
        echo "Memory Usage: " . (memory_get_usage()/1048576) . " MB \n";
        return 0;
    }

    /**
     * @return int
     * @throws \Auryn\ConfigException
     * @throws \Auryn\InjectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showScooters()
    {

        $pdo = Dependencies::getPDODependency();

        $scooters = Scooter::getAllEntries($pdo);

        $content = $this->twig->render('showVehicles.html.twig', [
            'vehicles' => $scooters,
            'vehicleType' => 'scooter'
        ]);

        $this->response->setContent($content);
        $this->response->headers->set('Content-Type', 'text/html');
        $this->response->setStatusCode(200);
        $this->response->send();
        return 0;
    }

}