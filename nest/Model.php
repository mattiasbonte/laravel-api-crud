<?php

namespace App\Models;

use App\Models\NEST_Upper_singular;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BASE_Upper_singular extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the NEST_lower_singular that this BASE_lower_singular belongs to.
     *
     * @return NEST_Upper_singular
     */
    public function NEST_lower_singular()
    {
        return $this->belongsTo(NEST_Upper_singular::class);
    }
}
