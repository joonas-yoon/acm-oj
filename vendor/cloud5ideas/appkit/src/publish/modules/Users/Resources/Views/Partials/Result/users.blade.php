<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped">
		      <thead>
		        <tr>
		          <th class="visible-md visible-lg"></th>
		          <th>First Name</th>
		          <th>Last Name</th>
		          <th>Email</th>
		        </tr>
		      </thead>
		      <tbody>
		      	@foreach ($users as $user)
		      		<tr {!! $user_id == $user->id ? 'class="info"' : null !!}>
			          <th class="visible-md visible-lg">
			          	@include('users::partials.index.actions', ['user' => $user])
			          </th>
			          <td class="visible-xs visible-sm">
			          	<a href="{{route('users.show', $user->id)}}" >
			          		{{$user->first_name}}
			          	</a>
			          </td>
			          <td>{{$user->first_name}}</td>
			          <td>{{$user->last_name}}</td>
			          <td>{{$user->email}}</td>
			        </tr>
		      	@endforeach
		      </tbody>
		    </table>
		</div>
	</div>
</div>