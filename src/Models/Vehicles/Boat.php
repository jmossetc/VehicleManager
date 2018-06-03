<?php
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 6:54 PM
 */

namespace ClickAndBoat\Models\Vehicles;

/**
 * Class Boat
 * @package ClickAndBoat\Models\Vehicles
 */
class Boat extends AbstractVehicle implements VehicleInterface
{
    /**
     * Boat constructor.
     * @param \PDO $pdo
     * @param int|null $id
     * @param string|null $name
     * @param string|null $type
     * @param string|null $fuel
     * @param int|null $fabricationYear
     */
    public function __construct(\PDO $pdo, int $id = null, string $name = null, string $type = null, string $fuel = null, int $fabricationYear = null)
    {
        parent::__construct($pdo, $id, $name, $type, $fuel, $fabricationYear);
    }


    /**
     * @return bool
     */
    public function persist()
    {
        $query = "INSERT INTO `boat` (`id`, `name`, `type`, `fabrication_year`, `fuel`) VALUES (NULL, '"
            . $this->getName() . "', '" . $this->getType() . "', '" . $this->getFabricationYear() . "', '"
            . $this->getFuel() . "'); ";
        $query = $this->pdo->prepare($query);
        $result = $query->execute();
        $this->setId($this->pdo->lastInsertId());
        return $result;
    }

    /**
     * @return Boat
     */
    public function update(): self
    {
        $query = "UPDATE `boat` SET `name` = '" . $this->getName() . "', `type` = '" . $this->getType() .
            "', `fabrication_year` = '" . $this->getFabricationYear() . "', `fuel` = '" . $this->getFuel() .
            "' WHERE `boat`.`id` = " . $this->getId() . "; ";
        $query = $this->pdo->prepare($query);
        $query->execute();

        return $this;
    }


    /**
     * Retrieve params of boat from id and set them
     * @param int $id
     * @return bool
     */
    public function mapFromDB(int $id) : bool
    {
        $query = 'SELECT * FROM boat WHERE id=' . $id . ' LIMIT 1';
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
     * Get all boats as object from DB
     * @param \PDO $pdo
     * @param [] $filters
     * @return Boat[]|
     */
    public static function getAllEntries(\PDO $pdo, $filters = null)
    {
        /**
         * @var Boat[] $boats
         */
        $boats = [];
        $sql = 'SELECT * FROM boat WHERE 1 ';
        if(isset($filters['name'])){
            $sql .= 'AND name LIKE \'%' . $filters['name'] . '%\' ';
        }
        $sql.= 'ORDER BY name';
        foreach ($pdo->query($sql) as $row) {
            $boats[] = new Boat(
                $pdo,
                (int)$row['id'],
                $row['name'],
                $row['type'],
                $row['fuel'],
                (int)$row['fabrication_year']
            );
        }

        return $boats;
    }
}