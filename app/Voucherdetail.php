<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucherdetail extends Model
{
    use SoftDeletes;

    protected $table = 'voucherdetails';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date'];

    protected $casts = [ 'wants_sync' => 'boolean', 'synced' => 'boolean'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'voucher_id', 'account_id', 'identification_id', 'doctype_id', 'detail', 'doc_number', 'date', 'debit', 'credit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function voucher()
    {
        return $this->belongsTo('App\Voucher', 'voucher_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id');
    }

    public function identification()
    {
        return $this->belongsTo('App\Identification', 'identification_id');
    }

    public function doctype()
    {
        return $this->belongsTo('App\Doctype');
    }
}
