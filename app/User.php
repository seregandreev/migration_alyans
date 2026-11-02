<?php

namespace App;

use App\Models\Company;
use App\Models\Unit;
use App\Models\WorkLocation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_password',
        'role',
        'position',
        'company_id',
        'bases_list',
        'phone',
        'company_on_register',
        'inspector_id',
        'blocking',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // закреплённая компания
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id')->first();
        //return $this->hasOne(WorkLocation::class, 'id', 'company_id')->first();
    }

    // список закреплённых баз
    public function bases_list()
    {
        if(is_array(json_decode($this->bases_list)) && count(json_decode($this->bases_list)) > 0)
        {
            $result = '<ul>';
            foreach(json_decode($this->bases_list, true) as $company_id)
            {
                $company = WorkLocation::find($company_id);
                $result .= '<li>'.$company->name.'</li>';
            }

            $result .= '</ul>';
        } else {
            $result = '<i>пусто</i>';
        }

        return $result;
    }
    
    public function inspector()
    {
        return $this->hasOne(Inspector::class, 'id', 'inspector_id')->first();
    }
}
