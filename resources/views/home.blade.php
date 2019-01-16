@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Check Ongkir</div>

                <div class="panel-body">

                    <form method="GET">
                      <div class="form-group">
                        <label for="exampleInputEmail1">City Origin</label>
                        <select class="form-control" name="origin">
                            @foreach($kota as $k)
                                <option value="{{ $k->city_id }}">{{ $k->city_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">City Destination</label>
                        <select class="form-control" name="destination">
                            @foreach($kota as $k)
                                <option value="{{ $k->city_id }}">{{ $k->city_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Berat(Gram)</label>
                        <input type="number" name="weight" class="form-control" id="exampleInputPassword1" placeholder="Berat">
                      </div>
                      <button type="submit" class="btn btn-default">Check Ongkir</button>
                    </form>

                    @if(count($arr))

                        @foreach($arr as $kurir)

                            @if(count($kurir['data']))
                            <div class="table-responsive">
                                <table class="table table-hover"> 
                                    <caption><img src="{{ $kurir['photo'] }}" class="img-responsive" height="50px;" width="50px;">{{ $kurir['name'] }}</caption>
                                    <thead> 
                                        <tr> 
                                            <th>Paket</th>
                                            <th>Nama Kurir</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Estimasi Pengiriman(hari)</th>
                                        </tr> 
                                    </thead> 
                                    <tbody> 

                                        @foreach($kurir['data'] as $paket)
                                            <tr> 
                                                <td>{{ $paket['paket'] }}</td> 
                                                <td>{{ $paket['name'] }}</td> 
                                                <td>{{ $paket['description'] }}</td> 
                                                <td>{{ 'Rp. '.number_format($paket['price'], 2) }}</td> 
                                                <td>{{ $paket['etd'] }}</td> 
                                            </tr>  
                                        @endforeach

                                    </tbody> 
                                </table>
                            </div>
                            @endif

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
