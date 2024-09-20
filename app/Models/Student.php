<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Guardian;
use \App\Models\User;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}