<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Order
 *
 * @property int $id
 * @property string $status
 *
 * @property Collection $products
 *
 * @package App\Models
 */
class Order extends Eloquent
{
    protected $table = 'order';
    public $timestamps = false;

    protected $fillable = [
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
