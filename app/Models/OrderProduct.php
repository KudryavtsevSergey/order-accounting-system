<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class OrderProduct
 *
 * @property int $order_id
 * @property int $product_id
 *
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderProduct extends Eloquent
{
	protected $table = 'order_product';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
