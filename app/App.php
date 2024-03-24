<?php

namespace App;

use App\Concerns\UsesUuid;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes, UsesUuid;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $gaurd = [];

    protected $fillable = [
        "id",
        "name",
        "icon",
        "token",
        "user_id",
        "expires_in",
        "invoice_num_prefix",
        "remote_auth_url",
        "remote_staff_data_url",
        "remote_products_data_url",
        "created_at",
        "updated_at",
    ];

    /**
     * Generates a token for app model
     */
    static function generateNewAppToken()
    {
        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $final_string = time() . ":" . substr(str_shuffle($original_string), 0, 32);
        return $final_string;
    }

    public function user()
    {
        return $this->belongsTo("App\\User");
    }

    public function appIdIsNull($builder, $role)
    {

        return DB::table('roles');
        // return $builder->orWhere(function ($query) {
        //     $query->where('app_id', "");
        // });
    }

    public function roles()
    {
        return $this->hasMany("App\\Role");
    }

    public function invoices()
    {
        return $this->hasMany("App\\Invoice");
    }

    public function products()
    {
        return $this->hasMany("App\\Product");
    }

    public function units()
    {
        return $this->hasMany("App\Unit");
    }

    public function conversions()
    {
        return $this->hasMany("App\\Conversion");
    }

    public function staffs()
    {
        return $this->hasMany("App\\Staff");
    }
}
