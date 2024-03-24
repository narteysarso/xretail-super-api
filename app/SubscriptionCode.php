<?php

namespace App;

use App\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SubscriptionCode extends Model
{
    use UsesUuid;
    //
    protected $table = "subscription_codes";
    protected $fillable = [
        'id',
        'code',
        'days',
        'app_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];



    public function app(): BelongsTo{
        return $this->belongsTo("App\\App");
    }
}
