<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['model', 'hdd', 'hdd_capacity', 'ram', 'ram_capacity',
        'location', 'price', 'created_at', 'updated_at'
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getHdd(): string
    {
        return $this->hdd;
    }

    /**
     * @return int
     */
    public function getHddCapacity(): int
    {
        return $this->hdd_capacity;
    }

    /**
     * @return string
     */
    public function getRam(): string
    {
        return $this->ram;
    }

    /**
     * @return int
     */
    public function getRamCapacity(): int
    {
        return $this->ram_capacity;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

}
