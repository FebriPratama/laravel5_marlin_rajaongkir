<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_ref_book extends Model
{

	protected $primaryKey = 'book_id';
    protected $appends = ['book_price_format_rp'];

    protected $fillable = [
        
        'book_name',
        'book_description',
        'book_keyword',
        'book_price',
        'book_penerbit',
        'book_stock'

    ];

    public static $columns = [
        
        'book_name',
        'book_description',
        'book_keyword',
        'book_price',
        'book_penerbit',
        'book_stock'

    ];

    public function getBookPriceFormatRpAttribute()
    {

        return 'Rp. '.number_format($this->book_price, 2);

    }

    public function check_cat($id){

        $val = false;

        foreach($this->categories as $cat){
            if($cat->bc_cat_id == $id) $val = true;
        }

        return $val;
    }

    public function categories()
    {
        return $this->hasMany('App\Tbl_trx_book_category','bc_book_id','book_id');
    }
    
}
