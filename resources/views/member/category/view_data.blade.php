@extends('home')

@section('konten')
	
	<div class="row">
		
		<div class="col-md-12">

			@if (session()->has('message'))
				<div class="alert alert-{{ session()->get('status') ? 'success' : 'warning' }} alert-dismissible fade show" role="alert">
				  {{ session()->get('message') }}
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif

		</div>

	</div>
	<div class="row">
		
		<div class="col-md-12">

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new">New</button>

		</div>
		<div class="col-md-4 col-md-offset-8">
			<form action="{{ route('view_cat') }}" method="GET">

				  <div class="form-group">
				    <input type="text" class="form-control" name="q" placeholder="Search">
				  </div>

				  <button type="submit" class="btn btn-primary">Search</button>

			</form>
		</div>
		<div class="col-md-12">
			
			<form action="{{ route('delete_multi_cat') }}">
			<div class="table-responsive">
				<table class="table table-hover"> 
					<thead> 
						<tr> 
							<th>#</th>
							<th>ID</th> 
							<th>Nama Kategori</th> 
							<th>Options</th>
						</tr> 
					</thead> 
					<tbody> 

						@foreach($datas as $data)
							<tr> 
								<th><input type="checkbox" value="{{ $data->cat_id }}" name="ids[]"></th> 
								<td>{{ $data->cat_id }}</td> 
								<td>{{ $data->cat_name }}</td>
								<th>
									<a href="" data-toggle="modal" data-target="#view-{{ $data->cat_id }}">View</a> | &nbsp;
									<a href="" data-toggle="modal" data-target="#edit-{{ $data->cat_id }}">Edit</a> | &nbsp;
									<a href="" data-toggle="modal" data-target="#delete-{{ $data->cat_id }}">Delete</a>
								</th>
							</tr>  
						@endforeach

					</tbody> 
				</table>
			</div>
			<button type="submit" name="delete" class="btn btn-danger">Delete Selected</button>
			</form>

			{{ $datas->links() }}
		</div>

	</div>

	@foreach($datas as $data)
		<!-- VIEW -- >
		<!-- Modal -->
		<div class="modal fade" id="view-{{ $data->cat_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">{{ $data->cat_name}}</h4>
		      </div>
		      <div class="modal-body">

				  <div class="form-group">
				    <label for="exampleInputEmail1">Nama</label> : {{ $data->cat_name}}
				  </div>

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>

		<!-- UPDATE -- >
		<!-- Modal -->
		<div class="modal fade" id="edit-{{ $data->cat_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		     <form method="post" action="{{ route('update_cat',array('id' => $data->cat_id )) }}">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">{{ $data->cat_name}}</h4>
		      </div>
		      <div class="modal-body">

				@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				{{ csrf_field() }}
			  <div class="form-group">
			    <label for="exampleInputEmail1">Nama</label>
			    <input type="text" class="form-control" value="{{ $data->cat_name }}" name="cat_name" aria-describedby="emailHelp" placeholder="Enter Name">
			  </div>

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<button type="submit" class="btn btn-primary">Update</button>
		      </div>

		     </form>
		    </div>
		  </div>
		</div>

		<!-- DELETE -- >
		<!-- Modal -->
		<div class="modal fade" id="delete-{{ $data->cat_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">DELETE {{ $data->cat_name}} ?</h4>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <a type="submit" href="{{ route('delete_cat',array('id' => $data->cat_id )) }}" class="btn btn-primary">DELETE</a>
		      </div>

		    </div>
		  </div>
		</div>
	@endforeach

	<!-- Modal -->
	<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    <form method="post" action="{{ route('add_cat') }}">	

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Add Data</h4>
	      </div>
	      <div class="modal-body">

			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			{{ csrf_field() }}
		  <div class="form-group">
		    <label for="exampleInputEmail1">Nama</label>
		    <input type="text" class="form-control" value="{{ old('cat_name') }}" name="cat_name" aria-describedby="emailHelp" placeholder="Enter Name">
		  </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>

	    </form>
	    </div>
	  </div>
	</div>

@endsection