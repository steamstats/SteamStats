@extends('layouts.app')

@section('content')

@if(!empty($game['background']))
    <img src="{{ $game['background'] }}" style="position: absolute;top:0;width: 100%;height: 100%;z-index: -1; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));">
@endif

@if ($errors->any())
    <script type="text/javascript">
		$('#reviewmodal').modal('show');
    </script>
@endif

@if(session('success'))
	<div class="alert alert-success text-center" role="alert">
		{{session('success')}}
	</div>
@endif

@if(session('error_steam_id'))
	<div class="alert alert-danger text-center" role="alert">
		{{session('error_steam_id')}}
	</div>
@endif

	<div class="container mt-5">
		<div class="row mb-3">
			<div class="col-md-12 col-12">
				<h1 class="float-left">{{ $game['name'] }}</h1>
                <a class="btn btn-info float-right" href="steam://install/{{$game['steam_appid']}}">Install</a><a class="btn btn-outline-info float-right mr-2" href="steam://launch/{{$game['steam_appid']}}">Launch</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<table class="table table-hover table-bordered table-dark" style="background-color: #282e39;">
					<tbody>
						<tr>
							<td>App ID</td>
							<td>{{ $game['steam_appid'] }}</td>
						</tr>
						<tr>
							<td>App Type</td>
							<td>{{ $game['type'] }}</td>
						</tr>
						<tr>
							<td>Publisher</td>
							<td>
                  <?php
                      if(!empty($game['publishers'])){
                          foreach($game['publishers'] as $publisher)
                              echo $publisher,", ";
                      } else
                          echo "None";
                  ?>
              </td>
						</tr>
						<tr>
							<td>Developer</td>
							<td>
                  <?php
                      if(!empty($game['developers'])){
                              foreach($game['developers'] as $developer)
                                  echo $developer,", ";
                      } else
                          echo "None";
                  ?>
              </td>
						</tr>
						<tr>
							<td>Supported Systems</td>
							<td>@if($game['platforms']['windows'] == true){{ "Windows " }}@endif @if($game['platforms']['mac'] == true){{ "Mac" }}@endif @if($game['platforms']['linux'] == true){{ "Linux" }}@endif</td>
						</tr>
						<tr>
							<td>Genre</td>
							<td>
                  <?php
                  if(!empty($game['genres'])){
                      foreach($game['genres'] as $genre)
                          echo $genre['description'],", ";
                  } else
                      echo "None";
                  ?>
              </td>
						</tr>
						<tr>
							<td>Last Change Number</td>
							<td>9855972</td>
						</tr>
						<tr>
							<td>Release Date</td>
							<td>@if($game['release_date']['coming_soon'] == false) {{$game['release_date']['date']}} @else {{ "Coming soon" }}@endif</td>
						</tr>
					</tbody>
				</table>
            </div>
			<div class="col-md-4">
				<img src="{{ $game['header_image'] }}" class="img-fluid">
				<div class="row mt-3">
                    <?php $strip1 = strtolower(str_replace(' ', '-', $game['name'])); $metacriticUrl = str_replace(':', '', $strip1) ?>
                    @if(!empty($game['metacritic']['score']))
                    <div class="col-md-5">
						<div class="alert alert-dark text-center" role="alert" style="border:none;
                        @if($game['metacritic']['score'] <= 49)
                            background-color: #f00;
                        @elseif($game['metacritic']['score'] <= 74)
                            background-color: #fc3;
                        @else
                            background-color: #6c3;
                        @endif
                         ">
							<h6 class="mb-0"><a href="{{$game['metacritic']['url']}}" class="text-dark" target="_blank">Metascore</a></h6>
							<span class="small text-black">{{ $game['metacritic']['score'] }}</span>
						</div>
					</div>
                    @else
                    <div class="col-lg-5">
                        <div class="alert alert-dark text-center" role="alert">
                            <h6 class="mb-0 text-dark"><a href="https://www.metacritic.com/game/pc/{{$metacriticUrl}}" class="text-dark" target="_blank">Metascore</a></h6>
                            <span class="small text-black"><i>No score</i></span>
                        </div>
                    </div>
                    @endif

					<div class="col-lg-7">
						<div class="alert alert-dark text-center" role="alert" style="border:none;">
							<h6 class="mb-0 text-green">Total recommendations</h6>
                            @if(!empty($game['recommendations']['total']))
                                <span class="small text-dark">{{ $game['recommendations']['total'] }}</span>
                            @else
                                <span class="small text-dark"><i>None</i></span>
                            @endif
						</div>
					</div>
				</div>
				<p class="text-white">{{ strip_tags($game['short_description']) }}</p>
			</div>
		</div>
        <div class="row">
            <div class="col-md-8 ">
                @if(!empty($game['packages']))
                    <h4>Packages</h4>
                    @foreach($game['packages'] as $packages)
                        <iframe src="https://store.steampowered.com/widget/{{$game['steam_appid']}}/{{$packages}}" frameborder="0" width="100%" height="200px"></iframe>
                    @endforeach
                @endif
            </div>
            <div class="col-md-4 mt-5 mt-md-0">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" style="">
                        <?php $isFirst = true; ?>
                            @if(!empty($game['screenshots'][0]['path_full']))
                                @foreach($game['screenshots'] as $screenshots)
                                <div class="carousel-item {{ $isFirst ? ' active' : '' }}">
                                    <img class="d-block w-100" src="{{ $screenshots['path_full'] }}" alt="slide">
                                    {{--                            @dd($game['screenshots'][0]['path_full'])--}}
                                </div>
                                <?php $isFirst = false;?>
                                @endforeach
                            @endif
                            @if(!empty($game['movies'][0]['mp4']))
                                @foreach($game['movies'] as $movies)
                                <div class="carousel-item">
                                    <video class="d-block w-100" controls><source src="{{ $movies['mp4']['480'] }}">Your browser does not support the video tag.</video>
                                    {{--                            @dd($game['screenshots'][0]['path_full'])--}}
                                </div>
                                @endforeach
                            @endif
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-5">
		<div class="row">
			<div class="col-md-{{ isset($stars) ? '6' : '12' }}">
				<h4>Requirements</h4>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Windows</a>
                    </li>
                    @if(!empty($game['mac_requirements']['minimum']))
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Mac OS X</a>
                    </li>
                        @endif
                    @if(!empty($game['linux_requirements']['minimum']))
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Linux</a>
                        </li>
                        @endif
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    @if(!empty($game['pc_requirements']['minimum']))
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">{!! $game['pc_requirements']['minimum'] !!}</div>
                        @endif
                    @if(!empty($game['mac_requirements']['minimum']))
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">{!! $game['mac_requirements']['minimum'] !!}</div>
                        @endif
                    @if(!empty($game['linux_requirements']['minimum']))
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">{!! $game['linux_requirements']['minimum'] !!}</div>
                        @endif
                </div>
			</div>

      @if(isset($stars))
        <div class="col-md-6">
            <div class="user_rating">
                <span class="heading">User Rating</span>
                <i class="text-warning {{ $stars['average'] >= 1 ? 'fas fa-star' : 'far fa-star' }} fa-2x"></i>
                <i class="text-warning {{ $stars['average'] >= 2 ? 'fas fa-star' : ($stars['average'] == '1.5' ? 'fas fa-star-half-alt' : 'far fa-star') }} fa-2x"></i>
                <i class="text-warning {{ $stars['average'] >= 3 ? 'fas fa-star' : ($stars['average'] == '2.5' ? 'fas fa-star-half-alt' : 'far fa-star') }} fa-2x"></i>
                <i class="text-warning {{ $stars['average'] >= 4 ? 'fas fa-star' : ($stars['average'] == '3.5' ? 'fas fa-star-half-alt' : 'far fa-star') }} fa-2x"></i>
                <i class="text-warning {{ $stars['average'] == 5 ? 'fas fa-star' : ($stars['average'] == '4.5' ? 'fas fa-star-half-alt' : 'far fa-star') }} fa-2x"></i>
                <p>{{$stars['average']}} stars average based on {{$stars['total']}} reviews.</p>

                <div class="row w-100 mx-auto">
                    <div class="side">
                        <div>5 stars</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-5" style="width: {{$stars['starPercentage']['5']}};"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div>{{$stars['5']}}</div>
                    </div>
                    <div class="side">
                        <div>4 stars</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-4" style="width: {{$stars['starPercentage']['4']}};"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div>{{$stars['4']}}</div>
                    </div>
                    <div class="side">
                        <div>3 stars</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-3" style="width: {{$stars['starPercentage']['3']}};"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div>{{$stars['3']}}</div>
                    </div>
                    <div class="side">
                        <div>2 stars</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-2" style="width: {{$stars['starPercentage']['2']}};"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div>{{$stars['2']}}</div>
                    </div>
                    <div class="side">
                        <div>1 star</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-1" style="width: {{$stars['starPercentage']['1']}};"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div>{{$stars['1']}}</div>
                    </div>
                </div>
            </div>
        </div>
      @endif

		</div>
		<hr class="my-5">
		<div class="row">
			<div class="col-md-9">
				<h2>Reviews</h2>
			</div>
			<div class="col-md-3">
				@auth
					<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#reviewmodal">
					    Leave review
					</button>
				@else
                    <a href='{{ url('/auth/steam') }}'><button type="button" class="btn btn-primary float-right">
                            Log in to Leave review
                        </button></a>
                @endif
			</div>
		</div>

		@if(!$reviews->isEmpty())
			<div class="row my-5">
				<div class="col-md-12">
					@foreach ($reviews as $review)
						<div class="card mt-3" style="background-color: #282e39">
						    <div class="card-body ">
						        <div class="row mb-3 mt-md-0">
						            <div class="col-md-1 d-none d-md-block">
						                <img src="{{$review['steam'][0]['avatar']}}" class="img img-rounded img-fluid" />
						            </div>
						            <div class="col-md-11">
						                <p>
						                    <a class="float-left" href="/user/{{ $review['steam'][0]['steamid'] }}"><strong>{{$review['steam'][0]['name']}}</strong></a>
						                    <span class="float-left ml-1">
						                    	<small class="text-muted">-
                                                    @if(isset($review['ago']))
                                                        {{$review['ago']}}
                                                        @if($review['created_at'] != $review['updated_at'] && isset($review['reviewAgo']))
                                                            <span data-toggle="tooltip" data-placement="top" title="{{ $review['reviewAgo'] }}">{{ ' • edited' }}</span>
                                                        @endif
                                                    @else
                                                        {{$review['created_at']->format('d/m/Y')}}
                                                        @if($review['created_at'] != $review['updated_at'] && isset($review['reviewAgo']))
                                                            <span data-toggle="tooltip" data-placement="top" title="{{ $review['reviewAgo'] }}">{{ ' • edited' }}</span>
                                                        @endif
                                                    @endif
						                    	</small>
						                    </span>
                                            <span class="float-right"><i class="text-warning {{ $review['stars'] == 5 ? 'fas' : 'far' }} fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning {{ $review['stars'] >= 4 ? 'fas' : 'far' }} fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning {{ $review['stars'] >= 3 ? 'fas' : 'far' }} fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning {{ $review['stars'] >= 2 ? 'fas' : 'far' }} fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning {{ $review['stars'] >= 1 ? 'fas' : 'far' }} fa-star"></i></span>
						                </p>
						                <div class="clearfix"></div>
						                <p>
						                    {{ $review['review'] }}
						                </p>
						                <p>
                                            @auth
                                                <button type="button" class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#replymodal{{$review['id']}}">
                                                    <i class="fa fa-reply"></i> Reply
                                                </button>
                                                @if($review['steam'][0]['steamid'] == Auth::user()->steamid)
                                                    <a class="btn btn-outline-danger float-right mr-2" href="/deleteReview/{{ $review['id'] }}">
                                                        <i class="text-white fas fa-trash-alt"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success float-right mr-2" href="/editReview/{{ $review['id'] }}">
                                                        <i class="text-white far fa-edit"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <a href='{{ url('/auth/steam') }}'><button type="button" class="float-right btn btn-outline-primary">
                                                        Log in to Leave reply
                                                    </button></a>
                                            @endif
						                </p>
						            </div>
						        </div>

                                @if(isset($review['replies']))
                                    @foreach($review['replies'] as $reply)

                                    <div class="card card-inner" style="background-color: #282e39">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="{{$reply['steam'][0]['avatar']}}" class="img img-rounded img-fluid" />
                                                </div>
                                                <div class="col-md-11">
                                                    <p>
                                                        <a class="float-left" href="/user/{{ $reply['steam'][0]['steamid'] }}"><strong>{{$reply['steam'][0]['name']}}</strong></a>
                                                        <span class="float-left ml-1">
                                                            <small class="text-muted">-
                                                                @if(isset($reply['ago']))
                                                                    {{$reply['ago']}}
                                                                    @if($reply['created_at'] != $reply['updated_at'] && isset($reply['replyAgo']))
                                                                        <span data-toggle="tooltip" data-placement="top" title="{{ $reply['replyAgo'] }}">{{ ' • edited' }}</span>
                                                                    @endif
                                                                @else
                                                                    {{$reply['created_at']->format('d/m/Y')}}
                                                                    @if($reply['created_at'] != $reply['updated_at'] && isset($reply['replyAgo']))
                                                                        <span data-toggle="tooltip" data-placement="top" title="{{ $reply['replyAgo'] }}">{{ ' • edited' }}</span>
                                                                    @endif
                                                                @endif
                                                            </small>
                                                        </span>
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <p>
                                                        {{ $reply['reply'] }}
                                                    </p>
                                                    @auth
                                                        @if($reply['steam'][0]['steamid'] == Auth::user()->steamid)
                                                            <p>
                                                                <a class="btn btn-outline-danger float-right mr-2" href="/deleteReply/{{ $reply['id'] }}">
                                                                    <i class="text-white fas fa-trash-alt"></i>
                                                                </a>
                                                                <a class="btn btn-outline-success float-right mr-2" href="/editReply/{{ $reply['id'] }}">
                                                                    <i class="text-white far fa-edit"></i>
                                                                </a>
                                                            </p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                @auth
                            <!-- Reply Modal -->
                                <div class="modal fade" id="replymodal{{$review['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content" style="background-color: #282e39">
                                            <div class="modal-header">
                                                <img src="{{asset('img/SteamStats_Logo_Transparent.png')}}" alt="Logo" style="width: 200px">
                                                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Leave review</h5> -->
                                                <div style="height: 63px;" class="d-flex justify-content-center">
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
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
                                                <form action="{{ route('createreply') }}" method="post">

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
                                                        <textarea class="form-control" name="reply" rows="5"></textarea>
                                                    </div>

                                                    <input type="text" name="review_id" value="{{ $review['id'] }}" hidden="true">
                                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
						    </div>
						</div>
                    @endforeach
				</div>
			</div>
		@else
			<div class="row my-5">
				<div class="col-md-12">
					<div class="card mt-3" style="background-color: #282e39">
					    <div class="card-body text-center">
					        <h5>No reviews placed yet.</h5>
					    </div>
					</div>
				</div>
			</div>
		@endif
	</div>

@auth
    <!-- Review Modal -->
    <div class="modal fade" id="reviewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: #282e39">
                <div class="modal-header">
                	<img src="{{asset('img/SteamStats_Logo_Transparent.png')}}" alt="Logo" style="width: 200px">
                    <!-- <h5 class="modal-title" id="exampleModalLongTitle">Leave review</h5> -->
                    <div style="height: 63px;" class="d-flex justify-content-center">
                    	<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
                    </div>
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
                    <form action="{{ route('createreview') }}" method="post">

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
                                <option value="1">1 star</option>
                                <option value="2">2 stars</option>
                                <option value="3">3 stars</option>
                                <option value="4">4 stars</option>
                                <option value="5">5 stars</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Review</label>
                            <textarea class="form-control" name="review" rows="5"></textarea>
                        </div>

                        <input type="text" name="appid" value="{{ $game['steam_appid'] }}" hidden="true">
                        <button type="submit" class="btn btn-success float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endif
@endsection

