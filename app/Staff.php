<?php

namespace App;

use App\Concerns\UsesUuid;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Authenticatable
{
    //
    use SoftDeletes, UsesUuid;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    use HasApiTokens, Notifiable;

    protected $table = "staffs";

    protected $fillable = [
        "id",
        "name",
        "email",
        "phone",
        "is_active",
        "app_id",
        "password",
        "created_at",
        "updated_at",
    ];


    protected $hidden = [
        'password', 'remember_token'
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany("App\\Invoice");
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo("App\\App");
    }

    public function products(): HasMany
    {
        return $this->hasMany("App\\Product");
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany("App\\Role");
    }

    public function units(): HasMany
    {
        return $this->hasMany("App\\Unit");
    }

    public function conversions(): HasMany
    {
        return $this->hasMany("App\\Conversion");
    }

    public function hasRole(String $rolename): bool
    {
        $role = $this->roles()->where('name', $rolename)->first();

        if ($role)
            return true;

        else return false;
    }
}
