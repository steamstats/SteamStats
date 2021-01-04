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
						<form action="{{ route('updatereview') }}" method="post">

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
						        <label>Rating (stars)</label>
						        <select class="form-control" name="stars">
						            <option value="1" {{ $review['stars'] == 1 ? 'selected' : '' }}>1 star</option>
						            <option value="2" {{ $review['stars'] == 2 ? 'selected' : '' }}>2 stars</option>
						            <option value="3" {{ $review['stars'] == 3 ? 'selected' : '' }}>3 stars</option>
						            <option value="4" {{ $review['stars'] == 4 ? 'selected' : '' }}>4 stars</option>
						            <option value="5" {{ $review['stars'] == 5 ? 'selected' : '' }}>5 stars</option>
						        </select>
						    </div>
						    <div class="form-group">
						        <label>Review</label>
						        <textarea class="form-control" name="review" rows="5">{{ $review['review'] }}</textarea>
						    </div>

						    <input type="text" name="id" value="{{ $review['id'] }}" hidden="true">
						    <input type="text" name="appid" value="{{ $review['appid'] }}" hidden="true">
						    <button type="submit" class="btn btn-success float-right"><i class="far fa-edit"></i> Edit</button>
						</form>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>





@endsection