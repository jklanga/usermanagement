@section('content')
<div class="page-header">
 <h3>Activity Logs</h3>
</div>
  {{ Form::open(array('url' => URL::to('admin/activitylogs/edit'), 'id' => 'update_form')) }}
	<div id="content" class="content">
	@if($activityLogs)
		<table class="table jquery-table table-bordered">
			<thead>
				<tr>					
	    			<th></th><th style="padding-left: 5px">User</th><th align="left" style="padding-left: 5px">Type</th><th style="padding-left: 5px">Description</th><th style="padding-left: 5px">Date Created</th>
				</tr>
			</thead>
			<tbody>
		    @foreach($activityLogs as $log)
		    	@if($r%2 == 0)
		    	<tr class="cm-row-status-a">
		    	@else
		    	<tr style="background-color: #e6e6e6" class="cm-row-status-a">
		    	@endif
		        	<td><a href="{{ URL::to('admin/viewlog?id=') }}{{ $log->id }}">View&nbsp;</a></td>
		        	<td>@if($log->user){{ $log->user->first_name }} {{ $log->user->last_name }}@else <div style="color:maroon">undefined</div> @endif</td>
		        	<td>{{ $log->activity_type }}</td>
		        	<td><p style="width: 400px; display: table-cell">{{ $log->description }}</p></td>
		        	<td>{{ $log->created_at }}</td>
		        </tr>
		        <input type="hidden" value="{{$r++}}">
		    @endforeach
	    </tbody>
	  </table>
	  @else
	   	<i>No Actvity Logs</i>
	  @endif
	</div>
	{{ Form::close() }}
@stop
