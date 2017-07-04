@section('content')
@if (isset($user))
	{{ Form::model($user, array('route' => array('admin.user.edit','id='.$user->id), 'id' => 'userEdit', 'role'=>'form','class'=>'form-horizontal')) }}
@else
	{{ Form::open(array('route' => 'admin.user.edit', 'id' => 'userNew', 'role'=>'form','class'=>'form-horizontal')) }}
@endif
<div class="page-header">
 <h3>User: <small> @if (isset($user)) {{ $user->first_name }} @else New @endif</small></h3>
</div>
<div class="panel panel-default">
	<div class="row">
   <div class="col-md-8">
		<div id="general" class="cm-tabs-content" style="padding-top: 5px;">
			<div class="form-group">
				{{ Form::label('first_name', 'Name', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				{{ Form::text('first_name', Input::old('first_name'), array('class' => 'input-control') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('last_name', 'Surname', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				{{ Form::text('last_name', Input::old('last_name'), array('class' => 'input-control') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('group_id', 'Group', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				@if (isset($user) && $user->group[0]->id == Sentry::getGroupProvider()->findByName('Admin')->id)
					Admin
					{{ Form::hidden('group_id',$user->group[0]->id) }}
				@else	
					@foreach($groups as $group)
					<label class="radio-inline">
							<input type="radio" @if((Input::old('group_id') == $group->id) || (isset($user) && $user->group[0]->id == $group->id)) checked @endif name="group_id" value="{{ $group->id }}"> {{ $group->name }}
					</label>
					@endforeach
				@endif
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('email', 'Email', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				{{ Form::email('email', Input::old('email'), array('class' => 'input-control') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('password', 'Password', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				{{ Form::password('password', array('class' => 'input-control') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'cm-required col-sm-2')) }}
				<div class="col-sm-8">
				{{ Form::password('password_confirmation', array('class' => 'input-control') ) }}
				</div>
			</div>
			<div align="center" class="form-group">
			  <div class="col-sm-6">
			    <button class="btn btn-md btn-success" type="submit">Submit</button>
			  </div>
			  <div class="col-sm-4">
			    <a href="{{URL::to('/admin/users')}}" class="btn btn-md btn-default">Cancel</a>
			  </div>
			</div>
		 </div>
		</div>
		@if (isset($user))
		<input type="hidden" name="id" value="{{ $user->id }}">
		<input type="hidden" name="data_before_edit" value="{{ $data_before_edit }}">
		@endif
		{{ Form::close() }}
	</div>
</div>
	
@stop
