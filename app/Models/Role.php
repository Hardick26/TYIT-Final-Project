<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'status'
    ];

    // Add role titles as constants if you want to ensure consistency
    const ROLES = [
        'Super Admin',
        'Administrator',
        'Moderator',
        'HR Manager',
        'Payroll Manager',
        'Data Analyst',
        'Department Head',
        'Employee'
    ];

    // You can also add a method to get all role titles
    public static function getRoleTitles()
    {
        return self::ROLES;
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
    
    // Many

    // One to Many
}
