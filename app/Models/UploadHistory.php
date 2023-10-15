<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadHistory extends Model
{
    use HasFactory;

     // Status
	const PENDING = 0;
	const PROCESSING = 1;
	const COMPLETED = 2;
	const FAILED = 3;

     /**
     * Constant only.
     *
     * @var string
     */
    const TABLE_NAME = 'upload_history';

    /**
     * The table and primary key associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'file_size',
        'file_hash',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::PENDING,
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'status' => 'integer',
    ];
}
