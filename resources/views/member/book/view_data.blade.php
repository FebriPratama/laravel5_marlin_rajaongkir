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
			<form action="{{ route('view_book') }}" method="GET">

				  <div class="form-group">
				    <input type="text" class="form-control" name="q" placeholder="Search">
				  </div>

				  <button type="submit" class="btn btn-primary">Search</button>

			</form>
		</div>
		<div class="col-md-12">
			
			<form action="{{ route('delete_multi_book') }}">
			<div class="table-responsive">
				<table class="table table-hover"> 
					<thead> 
						<tr> 
							<th>#</th>
							<th>ID</th> 
							<th>Judul Buku</th>
							<th>Description</th>
							<th>Kategori</th>
							<th>Keywords</th>
							<th>Harga</th>
							<th>Stok</th>
							<th>Penerbit</th> 
							<th>Options</th>
						</tr> 
					</thead> 
					<tbody> 

						@foreach($datas as $data)
							<tr> 
								<th><input type="checkbox" value="{{ $data->book_id }}" name="ids[]"></th> 
								<td>{{ $data->book_id }}</td> 
								<td>{{ $data->book_name }}</td> 
								<td>{{ $data->book_description }}</td>
								<td>
									@foreach($data->categories as $cat)
										@if(is_object($cat->category))
											{{ $cat->category->cat_name }} <br>
										@endif
									@endforeach
								</td>
								<td>
									{{ $data->book_keyword }}

								</td>
								<td>
									{{ $data->book_price_format_rp }}
								</td>
								<td>
									{{ $data->book_stock }}

								</td>
								<td>
									{{ $data->book_penerbit }}

								</td>
								<th>
									<a href="" data-toggle="modal" data-target="#view-{{ $data->book_id }}">View</a> | &nbsp;
									<a href="" data-toggle="modal" data-target="#edit-{{ $data->book_id }}">Edit</a> | &nbsp;
									<a href="" data-toggle="modal" data-target="#delete-{{ $data->book_id }}">Delete</a>
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
		<div class="modal fade" id="view-{{ $data->book_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">{{ $data->book_name }}</h4>
		      </div>
		      <div class="modal-body">

				  <div class="form-group">
				    <label for="exampleInputEmail1">Judul Buku</label>
				    {{ $data->book_name }}
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Description</label>
				    {{ $data->book_description }}
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Kategori</label>
					@foreach($data->categories as $cat)
						@if(is_object($cat->category))
							{{ $cat->category->cat_name }} ,
						@endif
					@endforeach
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Keywords</label>
				    {{ $data->book_keyword }}
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Harga</label>
				    {{ $data->book_price }}
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Stock</label>
				    {{ $data->book_stock }}
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Penerbit</label>
				    {{ $data->book_penerbit }}
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
		<div class="modal fade" id="edit-{{ $data->book_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		     <form method="post" action="{{ route('update_book',array('id' => $data->book_id )) }}">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">{{ $data->book_name }}</h4>
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
				    <label for="exampleInputEmail1">Judul Buku</label>
				    <input type="text" class="form-control" value="{{ $data->book_name }}" name="book_name" aria-describedby="emailHelp" placeholder="Enter Judul" required>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Description</label>
				    <textarea name="book_description" class="form-control" required>{{ $data->book_description }}</textarea>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Kategori</label>
					<select class="form-control" name="book_categories[]" multiple>

					  @foreach($categories as $cat)
					  	<option value="{{ $cat->cat_id }}" {{ $data->check_cat($cat->cat_id) ? 'SELECTED' : '' }}>{{ $cat->cat_name }}</option>
					  @endforeach

					</select>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Keywords</label>
				    <textarea name="book_keyword" class="form-control" required>{{ $data->book_keyword }}</textarea>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Harga</label>
				    <input type="number" class="form-control" value="{{ $data->book_price }}" name="book_price" required>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Stock</label>
				    <input type="number" class="form-control" value="{{ $data->book_stock }}" name="book_stock" required>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Penerbit</label>
				    <input type="text" class="form-control" value="{{ $data->book_penerbit }}" name="book_penerbit" aria-describedby="emailHelp" placeholder="Enter Penerbit" required>
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
		<div class="modal fade" id="delete-{{ $data->book_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">DELETE {{ $data->book_name}} ?</h4>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <a type="submit" href="{{ route('delete_book',array('id' => $data->book_id )) }}" class="btn btn-primary">DELETE</a>
		      </div>

		    </div>
		  </div>
		</div>
	@endforeach

	<!-- Modal -->
	<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    <form method="post" action="{{ route('add_book') }}">	

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
			    <label for="exampleInputEmail1">Judul Buku</label>
			    <input type="text" class="form-control" value="{{ old('book_name') }}" name="book_name" aria-describedby="emailHelp" placeholder="Enter Judul" required>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Description</label>
			    <textarea name="book_description" class="form-control" required>{{ old('book_description') }}</textarea>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Kategori</label>
				<select class="form-control" name="book_categories[]" multiple>

				  @foreach($categories as $cat)
				  	<option value="{{ $cat->cat_id }}">{{ $cat->cat_name }}</option>
				  @endforeach

				</select>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Keywords</label>
			    <textarea name="book_keyword" class="form-control" required>{{ old('book_keyword') }}</textarea>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Harga</label>
			    <input type="number" class="form-control" value="{{ old('book_price') }}" name="book_price" required>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Stock</label>
			    <input type="number" class="form-control" value="{{ old('book_stock') }}" name="book_stock" required>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Penerbit</label>
			    <input type="text" class="form-control" value="{{ old('book_penerbit') }}" name="book_penerbit" aria-describedby="emailHelp" placeholder="Enter Penerbit" required>
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