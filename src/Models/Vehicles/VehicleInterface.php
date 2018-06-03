<?php
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 6:36 PM
 */

namespace ClickAndBoat\Models\Vehicles;

/**
 * Interface VehicleInterface
 * @package ClickAndBoat\Models\Vehicles
 */
interface VehicleInterface
{

    /**
     * VehicleInterface constructor.
     * @param \PDO $pdo
     * @param int|null $id
     * @param string|null $name
     * @param string|null $type
     * @param string|null $fuel
     * @param int|null $fabricationYear
     */
    public function __construct(\PDO $pdo, int $id = null, string $name = null, string $type = null, string $fuel = null, int $fabricationYear = null);

    /**
     * @param int $id
     */
    public function setId(int $id);

    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param string $type
     */
    public function setType(string $type);

    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @param int $year
     */
    public function setFabricationYear(int $year);

    /**
     * @return int
     */
    public function getFabricationYear() : int;

    /**
     * @param string $fuel
     */
    public function setFuel(string $fuel);

    /**
     * @return string
     */
    public function getFuel() : string;


    /**
     * @return bool
     */
    public function persist();

    /**
     * @return Boat
     */
    public function update();

    /**
     * Retrieve params of boat from id and set them
     * @param int $id
     * @return bool
     */
    public function mapFromDB(int $id) : bool ;

    /**
     * @param \PDO $pdo
     * @param [] $filters
     * @return VehicleInterface[]
     */
    public static function getAllEntries(\PDO $pdo, $filters);


}