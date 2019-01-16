<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_trx_book_category extends Model
{

	protected $primaryKey = 'bc_id';

    protected $fillable = [
        
        'bc_cat_id',
        'bc_book_id'

    ];

    public function category(){
    	
    	return $this->belongsTo('App\Tbl_ref_category','bc_cat_id','cat_id');

    }
}
