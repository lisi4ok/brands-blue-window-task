<?php

namespace App\Models;

use App\Interfaces\HasImageInterface;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model implements HasImageInterface
{
    use HasFactory, HasImage;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'rating',
        'geolocation',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'default_image_url',
        'image_url',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
