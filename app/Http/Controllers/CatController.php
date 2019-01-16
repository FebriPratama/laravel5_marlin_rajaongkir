<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Tbl_ref_category;

use Illuminate\Support\Facades\Log;
class CatController extends Controller
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
    public function view_cat_data(Request $request)
    {
		$order = trim($request->input('orderBy')) !== '' ? $request->input('orderBy') : 'created_at';
		$orderDirection = $request->input('orderDirection') == 'true' ? 'ASC' : 'DESC';
		$paginate = trim($request->input('total')) !== '' ? $request->input('total') : 10;

    	$datas = new Tbl_ref_category;
		
		if(trim($request->input('q')) !== ''){

            $datas->where(function($query) use ($request)
            {

            	foreach(Tbl_ref_category::$columns as $c){

                	$query->orWhere($c, 'LIKE', '%'.$request->input('q').'%');

            	}

            });

		}
		
		$datas = $datas->orderBy($order,$orderDirection)->paginate($paginate);	

        return view('member.category.view_data',compact('datas'));
    }

    public function add_cat_proses(Request $request){

        $input = [
            
            'cat_name' => $request->input('cat_name')
        ];

        $validator = Validator::make($input, [
            
            'cat_name' => 'required'

        ]);

        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Tbl_ref_category::create($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function update_cat_proses(Request $request,$id){

        $input = [
            
            'cat_name' => $request->input('cat_name')
        ];

        $validator = Validator::make($input, [
            
            'cat_name' => 'required'

        ]);

        $cat = Tbl_ref_category::find($id);

        if ($validator->fails() || !is_object($cat)) {


            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $cat->update($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function delete_cat_proses(Request $request,$id){

        $input = [
            
            'cat_name' => $request->input('cat_name')
        ];

        $validator = Validator::make($input, [
            
            'cat_name' => 'required'

        ]);

        $cat = Tbl_ref_category::find($id);

        if (!is_object($cat)) {

				return back()
        			->with('status',1)
                    ->with('message','Data not found');
        }

        $cat->delete();

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

    public function delete_multi_cat_proses(Request $request){


    	foreach($request->input('ids') as $id){


    		$cat = Tbl_ref_category::find($id);

    		if (is_object($cat)) {

    			$cat->delete();

    		}

    	}

        return back()
        			->with('status',1)
                    ->with('message','Success');
    }
}
