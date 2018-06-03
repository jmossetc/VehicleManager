<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Lothar Lansing
 * Date: 6/3/2018
 * Time: 6:44 PM
 */

namespace ClickAndBoat\Models\Vehicles;

/**
 * Class AbstractVehicle
 * @package ClickAndBoat\Models\Vehicles
 */
abstract class AbstractVehicle implements VehicleInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $fuel;
    /**
     * @var int
     */
    protected $fabricationYear;

    /**
     * AbstractVehicle constructor.
     * @param \PDO $pdo
     * @param int|null $id
     * @param string|null $name
     * @param string|null $type
     * @param string|null $fuel
     * @param int|null $fabricationYear
     */
    public function __construct(\PDO $pdo, int $id = null, string $name = null, string $type = null, string $fuel = null, int $fabricationYear = null)
    {
        $this->pdo = $pdo;
        if (isset($id))
            $this->setId($id);
        if (isset($name))
            $this->setName($name);
        if (isset($type))
            $this->setType($type);
        if (isset($fuel))
            $this->setFuel($fuel);
        if (isset($fabricationYear))
            $this->setFabricationYear($fabricationYear);

    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param int $year
     */
    public function setFabricationYear(int $year)
    {
        $this->fabricationYear = $year;
    }

    /**
     * @return int
     */
    public function getFabricationYear(): int
    {
        return $this->fabricationYear;
    }

    /**
     * @param string $fuel
     */
    public function setFuel(string $fuel)
    {
        $this->fuel = $fuel;
    }

    /**
     * @return string
     */
    public function getFuel(): string
    {
        return $this->fuel;
    }

    /**
     * @return bool
     */
    public abstract function persist();

    /**
     * @return Boat
     */
    public abstract function update();

    /**
     * Retrieve params of Vehicle from id and set them
     * @param int $id
     * @return bool
     */
    public abstract function mapFromDB(int $id): bool;

    /**
     * Get all abstract vehicles as object from DB
     * @param \PDO $pdo
     * @param [] $filters
     * @return AbstractVehicle[]
     */
    public abstract static function getAllEntries(\PDO $pdo, $filters);
}