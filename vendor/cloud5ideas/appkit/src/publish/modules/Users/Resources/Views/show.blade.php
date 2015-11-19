@extends('shell::layouts.app')
@section('title')
    @parent
    {{$user->first_name}} {{$user->last_name}}
@stop

@section('breadcrumbs')
    @parent
    <a href="{{route('users.index')}}" class="btn btn-default">Users</a>
    <a href="#" class="btn btn-default">{{$user->first_name}} {{$user->last_name}}</a>
@stop

@section('content')
	<div class="panel panel-info">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-3 col-lg-3 " align="center"> 
					<img alt="User Pic" src="{{asset($user->image)}}" class="img-thumbnail"> 
				</div>
				<div class=" col-md-9 col-lg-9 "> 
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td><strong>First Name</strong></td>
									<td>{{ $user->first_name }}</td>
								</tr>
								<tr>
									<td><strong>Last name</strong></td>
									<td>{{ $user->last_name }}</td>
								</tr>
								<tr>
									<td><strong>Email</strong></td>
									<td><a href="mailto:{{$user->email}}">{{ $user->email }}</a></td>
								</tr>
								<tr>
									<td><strong>Disabled</strong></td>
									<td>{{ $user->isDisabled() ? 'Yes' : 'No' }}</td>
								</tr>
								<tr>
									<td><strong>Created At</strong></td>
									<td>{{ $user->created_at }}</td>
								</tr>
								<tr>
									<td><strong>Last Updated At</strong></td>
									<td>{{ $user->updated_at }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			@include('users::partials.show.actions')
		</div> 
	</div>
@endsection