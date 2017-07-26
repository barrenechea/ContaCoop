<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'codigo', 'fecucode_id', 'clase', 'nivel', 'subcta', 'ctacte',
    	'ctacte2', 'ctacte3', 'ctacte4', 'estado', 'estado2', 'nombre',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function fecucode()
    {
        return $this->belongsTo('App\FECUCode');
    }

    public function bank()
    {
        return $this->hasOne('App\Bank');
    }

    public function voucherdetails()
    {
        return $this->hasMany('App\Voucherdetail');
    }
}
