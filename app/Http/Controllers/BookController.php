<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Tbl_ref_category;
use App\Tbl_ref_book;
use App\Tbl_trx_book_category;


use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_book_data(Request $request)
    {
		$order = trim($request->input('orderBy')) !== '' ? $request->input('orderBy') : 'created_at';
		$orderDirection = $request->input('orderDirection') == 'true' ? 'ASC' : 'DESC';
		$paginate = trim($request->input('total')) !== '' ? $request->input('total') : 10;

    	$datas = new Tbl_ref_book;
		
		if(trim($request->input('q')) !== ''){

            $datas->where(function($query) use ($request)
            {

            	foreach(Tbl_ref_book::$columns as $c){

                	$query->orWhere($c, 'LIKE', '%'.$request->input('q').'%');

            	}

            });

		}
		
		$datas = $datas->orderBy($order,$orderDirection)->paginate($paginate);	

		$categories = Tbl_ref_category::all();

        return view('member.book.view_data',compact('datas','categories'));
    }

    public function add_book_proses(Request $request){

        $input = [
            
	        'book_name' => $request->input('book_name'),
	        'book_description' => $request->input('book_description'),
	        'book_keyword' => $request->input('book_keyword'),
	        'book_price' => $request->input('book_price'),
	        'book_penerbit' => $request->input('book_penerbit'),
	        'book_stock' => $request->input('book_stock')

        ];

        $validator = Validator::make($input, [
            
            'book_name' => 'required',
            'book_description' => 'required',
            'book_keyword' => 'required',
            'book_price' => 'required',
            'book_penerbit' => 'required',
            'book_stock' => 'required'

        ]);

        $categories = $request->input('book_categories');
        
        if(!count($categories)){

	        return back()
	        			->with('status',1)
	                    ->with('message','Category Field is required');
        }

        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $book = Tbl_ref_book::create($input);

        if(is_object($book)){
	
	        foreach($categories as $cat){

	        	$input = array(

			        'bc_cat_id' => $cat,
			        'bc_book_id' => $book->book_id

	        	);

	        	Tbl_trx_book_category::create($input);

	        }
    
        }

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function update_book_proses(Request $request,$id){


        $input = [
            
	        'book_name' => $request->input('book_name'),
	        'book_description' => $request->input('book_description'),
	        'book_keyword' => $request->input('book_keyword'),
	        'book_price' => $request->input('book_price'),
	        'book_penerbit' => $request->input('book_penerbit'),
	        'book_stock' => $request->input('book_stock')

        ];

        $validator = Validator::make($input, [
            
            'book_name' => 'required',
            'book_description' => 'required',
            'book_keyword' => 'required',
            'book_price' => 'required',
            'book_penerbit' => 'required',
            'book_stock' => 'required'

        ]);

        $book = Tbl_ref_book::find($id);

        $categories = $request->input('book_categories');
        
        if(!count($categories)){

	        return back()
	        			->with('status',1)
	                    ->with('message','Category Field is required');
        }

        if ($validator->fails() || !is_object($book)) {


            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $book->update($input);

        // delete old
        foreach($book->categories as $cat){

        	if(is_object($cat)) $cat->delete();
        }

        //input new
        foreach($categories as $cat){

        	$input = array(

		        'bc_cat_id' => $cat,
		        'bc_book_id' => $book->book_id

        	);

        	Tbl_trx_book_category::create($input);

        }

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function delete_book_proses(Request $request,$id){

        $book = Tbl_ref_book::find($id);

        if (!is_object($book)) {

				return back()
        			->with('status',1)
                    ->with('message','Data not found');
        }

        $book->delete();

        foreach($book->categories as $cat){

        	if(is_object($cat)) $cat->delete();
        }

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function delete_multi_book_proses(Request $request){


    	foreach($request->input('ids') as $id){


    		$book = Tbl_ref_book::find($id);

    		if (is_object($book)) {

    			$book->delete();

		        foreach($book->categories as $cat){

		        	if(is_object($cat)) $cat->delete();
		        }

    		}

    	}

        return back()
        			->with('status',1)
                    ->with('message','Success');
    }
}
