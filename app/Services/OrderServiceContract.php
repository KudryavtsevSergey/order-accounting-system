<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;

interface OrderServiceContract
{
    /**
     * @param array $products
     * @return Model
     */
    public function store(array $products): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function upgradeStatus(int $id): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function lowerStatus(int $id): Model;
}
