<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    /**
     * Get the user that owns the user role.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    /**
     * Get the role that owns the user role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
