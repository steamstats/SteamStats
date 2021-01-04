@extends('layouts.app')

@section('content')

@if(session('error_steam_id'))
	<div class="alert alert-danger text-center" role="alert">
		{{session('error_steam_id')}}
	</div>
@endif



<div class="container">
	<div class="col-md-12">
		<div class="card mt-3" style="background-color: #282e39">
		    <div class="card-body ">
		        <div class="row mb-3 mt-md-0">
		            <div class="col-md-12">
						<form action="{{ route('destroyreply') }}" method="post">

						    {{ csrf_field() }}

						    <div class="form-group">
						        <div class="row">
						            <div class="col-2">
						                <label>Avatar<img src="{{ Auth::user()->avatar }}" class="img-fluid"></label>
						            </div>
						            <div class="col-10">
						                <label class="w-100">Username<input type="text" class="form-control" placeholder="Steam name" name="steamname" value="{{ Auth::user()->name }}" readonly="true">
						                    <input type="text" class="form-control" placeholder="Steam ID" name="steamid" value="{{ Auth::user()->steamid }}" hidden="true"></label>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
						        <label>Reply</label>
						        <textarea class="form-control" name="reply" rows="5" readonly="true">{{ $reply['reply'] }}</textarea>
						    </div>

						    <input type="text" name="id" value="{{ $reply['id'] }}" hidden="true">
						    <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt"></i> Delete</button>
						</form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>





@endsection