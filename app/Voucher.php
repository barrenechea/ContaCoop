<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $table = 'vouchers';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date', 'check_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'type', 'sequence', 'date', 'description', 'bank_id', 'check_number', 'check_date', 'beneficiary', 'img', 'wants_sync', 'synced'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function voucherdetails()
    {
        return $this->hasMany('App\Voucherdetail');
    }

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
