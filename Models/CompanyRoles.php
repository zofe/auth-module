<?php

namespace App\Modules\Auth\Models;

use App\Models\Company;

use App\Models\User;
use App\Traits\ShortId;
use App\Traits\SSearch;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CompanyRoles extends Model
{
    use SSearch;
    use Uuid, ShortId;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'company_roles';

    protected $casts = [
        'permissions'     => 'array',
    ];

    protected $guarded = [];

    public static function ssearch($search)
    {
        return static::query()->where(function ($query) use ($search) {
            $query
                ->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('company', function( $q ) use ($search) {
                    $q->where('business_name', 'like', '%' . $search . '%')
                    ->orWhere('firstname', 'like', '%'.$search.'%')
                    ->orWhere('lastname', 'like', '%'.$search.'%')
                ;
            });
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_role_id', 'id');
    }
}
