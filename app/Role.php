<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes, UsesUuid;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        "id",
        "name",
        "created_at",
        "updated_at",
    ];

    public function app(): BelongsTo
    {
        return $this->belongsTo("App\\App");
    }

    public function staffs(): BelongsToMany
    {
        return $this->belongsToMany("App\\Staff");
    }
}
