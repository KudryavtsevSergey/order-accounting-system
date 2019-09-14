<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection $orders
 *
 * @package App\Models
 */
class Product extends Eloquent
{
    protected $table = 'product';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
