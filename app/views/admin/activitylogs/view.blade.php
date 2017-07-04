@section('content')
@include('notifications')
@if (isset($log))
	{{ Form::model($log, array('route' => array('admin.viewlog','id='.$log->id), 'id' => 'logView', 'role'=>'form','class'=>'form-horizontal')) }}
@else
	{{ Form::open(array('route' => 'admin.viewlog', 'id' => 'logNew')) }}
@endif
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-10">
			<div class="panel_title"><h4 class="col-md-8">Log No.: {{ $log->id }} | User: {{ $log->user->first_name }}</h4></div>
			<div class="pull-right">
			  	<a href="{{ URL::to('/admin/activitylogs') }}"><button type="button" name="cancel" class="btn btn-primary">
			    	Close
			  	</button></a>
			</div>
			</div>
		</div>
	</div><!--Close panel-heading-->
    <div class="row">
	   <div class="col-md-10">
		<div id="general" class="cm-tabs-content" style="padding-top: 5px;">
			<div class="form-group">
				{{ Form::label('user', 'User', array('class' => 'col-sm-2','style'=>'float:left')) }}
				<div class="col-sm-10">
				{{ Form::text('user', $log->user->first_name.' '.$log->user->last_name, array('class' => 'input-control','readonly'=>'') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('description', 'Description', array('class' => 'col-sm-2','style'=>'float:left')) }}
				<div class="col-sm-10">
				{{ Form::textarea('description', Input::old('description'), array('class' => 'input-control','rows'=>5,'readonly'=>'') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('data', 'Data', array('class' => 'col-sm-2','style'=>'float:left')) }}
				<div class="col-sm-10">
				{{ Form::textarea('data', $log->data, array('class' => 'input-control','rows'=>7,'readonly'=>'') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('ip_address', 'IP Address', array('class' => 'col-sm-2','style'=>'float:left')) }}
				<div class="col-sm-10">
				{{ Form::text('ip_address', Input::old('ip_address'), array('class' => 'input-control','readonly'=>'') ) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('date_created', 'Date Created', array('class' => 'col-sm-2','style'=>'float:left')) }}
				<div class="col-sm-10">
				{{ Form::text('date_created', Input::old('date_created'), array('class' => 'input-control','readonly'=>'') ) }}
				</div>
			</div>
		</div>
	</div>
		{{ Form::close() }}
	</div>
</div>
	
@stop
