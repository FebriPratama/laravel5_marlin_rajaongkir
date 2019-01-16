<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use URL;

define('API', 'b050d0f5a3517467fe28db19556bcc86');

class HomeController extends Controller
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
    public function index(Request $request)
    {
        $arr = array();

        /* Ambil kota gan */
        $url = "http://pro.rajaongkir.com/api/city";
        $kota = HomeController::getApi($url,"GET");
        $kota = is_object($kota) ? $kota->rajaongkir->results : array();

        /* Lihat ongkir gan */
        $url = "http://pro.rajaongkir.com/api/cost";

        $params = array(
            
            'origin' => $request->input('origin'),
            'destination' => $request->input('destination'),
            'originType' => 'city',
            'destinationType' => 'city',
            'weight' => $request->input('weight'),
            'courier' => 'jne:pos:tiki:wahana:rpx:pcp:pandu:esl'

            );

        $rules = array(
            
            'origin' => 'required|numeric',
            'destination' =>'required|numeric',
            'weight' => 'required|numeric',
            'courier' => 'required'

            );

        $validation = Validator::make($params, $rules);

        if($validation->passes()){

            $data = HomeController::getApi($url,"POST",$params);

            $data = $data->rajaongkir;

            if(!is_object($data)){

                $arr = [];
            }

            if(!array_key_exists('results', $data)) return array('status'=>0,'message'=>'Wrong Params : '.$data['status']['description'],'data'=>array());

            $result = $data->results;

            $i = 0;

            foreach ($result as $key) {

                switch ($key->code) {
                    case 'jne':
                         $photo = url('img/jne.gif');
                        break;
                    case 'pos':
                         $photo = url('img/pos.gif');
                        break;
                    case 'tiki':
                         $photo = url('img/tiki.gif');
                        break;
                    default:
                        $photo = 'http://dummyimage.com/420x380/2980b9/fff.png&text='.strtoupper($key->code[0]);
                        break;
                }

                $child = array();

                foreach ($key->costs as $val) {

                    $child[] = array(

                        'paket' => $val->service,
                        'name' => $key->name,
                        'city_from' => $request->input('origin'),
                        'city_to' => $request->input('destination'),
                        'weight' => $data->query->weight,
                        'description' => $val->description,
                        'price' => $val->cost[0]->value,
                        'etd' => $val->cost[0]->etd 

                        );

                }

                $arr[] = array(

                    'name' => $key->name,
                    'photo' => $photo,
                    'data' => $child

                    );
                
            }

        }

        return view('home',compact('kota','arr'));
    }

    /*
        Curl

        @URL
        @Method
        @params

    */

    public static function getApi($url,$method,$param = array()){

        $curl = curl_init();

        switch ($method) {
            case 'GET':

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "key: b050d0f5a3517467fe28db19556bcc86"
                  ),
                ));
                
                break;
            case 'POST':

                $params = "";

                foreach ($param AS $key => $value) {

                    $params = $params.$key."=".$value."&";

                }

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 60,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $params,
                  CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: b050d0f5a3517467fe28db19556bcc86"
                  ),
                ));

                break;
            default:
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "key: b050d0f5a3517467fe28db19556bcc86"
                  ),
                ));
                break;
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

          return json_decode($err);

        } else {

          return json_decode($response);

        }

    }


}
