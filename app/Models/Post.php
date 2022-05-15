<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    use HasFactory;

    public static function boot()
    {

        parent::boot();

        self::created(function ($model) {
            Artisan::call('email:website-subscribers', ['post' => $model]);
        });

    }

    /**
     * @var string[]
     */
    protected $fillable = [
        'website_id',
        'title',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
