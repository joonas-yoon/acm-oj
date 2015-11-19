<div class="panel panel-default">
    <div class="panel-body">
        {!! Form::open(['route' => 'users.search']) !!}
			<div class="input-group">
				{!! Form::text('query', null, ['class' => 'form-control', 'placeholder' => 'Search...']) !!}
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i> Search</button>
				</span>
		    </div>
		 {!! Form::close() !!}
    </div>
</div>