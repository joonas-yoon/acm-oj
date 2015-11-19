<!DOCTYPE html>
<html lang="en">
	@include('shell::partials.head')
	<body>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-4 col-md-offset-4">
	            	<h3 class="text-center">{{ config('appkit.app_name') }}</h3>
	                <div class="panel panel-default">
	                    <div class="panel-heading">
	                        <h3 class="panel-title">@section('title')@show</h3>
	                    </div>
	                    <div class="panel-body">
	                    	@include('appkit::errors')
							@yield('content')
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</body>
</html>