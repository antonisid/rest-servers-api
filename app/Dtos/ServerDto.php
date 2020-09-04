<?php
declare(strict_types=1);

namespace App\Dtos;

class ServerDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $hdd;

    /**
     * @var int
     */
    private $hddCapacity;

    /**
     * @var string
     */
    private $ram;

    /**
     * @var int
     */
    private $ramCapacity;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function getHdd(): string
    {
        return $this->hdd;
    }

    /**
     * @param string $hdd
     * @return $this
     */
    public function setHdd(string $hdd): self
    {
        $this->hdd = $hdd;

        return $this;
    }

    /**
     * @return int
     */
    public function getHddCapacity(): int
    {
        return $this->hddCapacity;
    }

    /**
     * @param int $hddCapacity
     * @return $this
     */
    public function setHddCapacity(int $hddCapacity): self
    {
        $this->hddCapacity = $hddCapacity;

        return $this;
    }

    /**
     * @return string
     */
    public function getRam(): string
    {
        return $this->ram;
    }

    /**
     * @param string $ram
     * @return $this
     */
    public function setRam(string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * @return int
     */
    public function getRamCapacity(): int
    {
        return $this->ramCapacity;
    }

    /**
     * @param int $ramCapacity
     * @return $this
     */
    public function setRamCapacity(int $ramCapacity): self
    {
        $this->ramCapacity = $ramCapacity;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
