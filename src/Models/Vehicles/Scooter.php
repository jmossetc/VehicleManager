<?php
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 6:54 PM
 */

namespace ClickAndBoat\Models\Vehicles;

/**
 * Class Scooter
 * @package ClickAndBoat\Models\Vehicles
 */
class Scooter extends AbstractVehicle implements VehicleInterface
{
    public function __construct(\PDO $pdo, int $id = null, string $name = null, string $type = null, string $fuel = null, int $fabricationYear = null)
    {
        parent::__construct($pdo, $id, $name, $type, $fuel, $fabricationYear);
    }


    /**
     * @return bool
     */
    public function persist()
    {
        $query = "INSERT INTO `scooter` (`id`, `name`, `type`, `fabrication_year`, `fuel`) VALUES (NULL, '"
            . $this->getName() . "', '" . $this->getType() . "', '" . $this->getFabricationYear() . "', '"
            . $this->getFuel() . "'); ";
        $query = $this->pdo->prepare($query);
        $result = $query->execute();
        $this->setId($this->pdo->lastInsertId());
        return $result;
    }

    /**
     * @return Scooter
     */
    public function update(): self
    {
        $query = "UPDATE `scooter` SET `name` = '" . $this->getName() . "', `type` = '" . $this->getType() .
            "', `fabrication_year` = '" . $this->getFabricationYear() . "', `fuel` = '" . $this->getFuel() .
            "' WHERE `scooter`.`id` = " . $this->getId() . "; ";
        $query = $this->pdo->prepare($query);
        $query->execute();

        return $this;
    }


    /**
     * Retrieve params of scooter from id and set them
     * @param int $id
     * @return bool
     */
    public function mapFromDB(int $id) : bool
    {
        $query = 'SELECT * FROM scooter WHERE id=' . $id . ' LIMIT 1';
        $query= $this->pdo->prepare($query);
        $query->execute();
        $row = $query->fetch();
        if($row['id'] === null)
            return false;
        $this->setId((int)$row['id']);
        $this->setName($row['name']);
        $this->setType($row['type']);
        $this->setFuel($row['fuel']);
        $this->setFabricationYear((int)$row['fabrication_year']);

        return true;

    }


    /**
     * Get all scooters as object from DB
     * @param \PDO $pdo
     * @param [] $filters
     * @return Scooter[]|
     */
    public static function getAllEntries(\PDO $pdo, $filters = null)
    {
        /**
         * @var Scooter[] $scooters
         */
        $scooters = [];
        $sql = 'SELECT * FROM scooter WHERE 1 ';
        if(isset($filters['name'])){
            $sql .= 'AND name LIKE \'%' . $filters['name'] . '%\' ';
        }
        $sql.= 'ORDER BY name';
        foreach ($pdo->query($sql) as $row) {
            $scooters[] = new Scooter(
                $pdo,
                (int)$row['id'],
                $row['name'],
                $row['type'],
                $row['fuel'],
                (int)$row['fabrication_year']
            );
        }

        return $scooters;
    }
}