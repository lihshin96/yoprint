<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

     /**
     * Constant only.
     *
     * @var string
     */
    const TABLE_NAME = 'products';

    /**
     * The table and primary key associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'UNIQUE_KEY';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UNIQUE_KEY',
        'PRODUCT_TITLE',
        'PRODUCT_DESCRIPTION',
        'STYLE#',
        'SANMAR_MAINFRAME_COLOR',
        'SIZE',
        'COLOR_NAME',
        'PIECE_PRICE',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'PIECE_PRICE' => 0,
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'PIECE_PRICE' => 'decimal:4',
    ];
}
