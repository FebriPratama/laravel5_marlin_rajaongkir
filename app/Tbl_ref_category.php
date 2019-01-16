<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_ref_category extends Model
{

	protected $primaryKey = 'cat_id';

    protected $fillable = [
        
        'cat_name'

    ];

    public static $columns = array(

        'cat_name'

        );

}
