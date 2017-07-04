@section('content')
<div class="page-header">
 <h3>Users</h3>
 <div class="pull-right">
  <a href="{{URL::to('admin/user/edit')}}" class="btn btn-md btn-primary">New User</a>
</div>
</div>
	@if($users)
		<table class="table jquery-table table-bordered">
			<thead>
				<tr>
					<th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Group</th>
				</tr>
				</thead>
				<tbody>
		    @foreach($users as $user)
		    	<tr class="cm-row-status-a">
		        <td>
		        	@if ($currentUser->hasAccess('user.edit'))
								<a href="{{ URL::to('admin/user/edit?id=') }}{{ $user->id }}">#{{ $user->id }}&nbsp;</a>
							@else 
								{{ $user->id }}
							@endif
						</td>
		        <td>
						{{ $user->first_name }}
						</td>
						<td>
						{{ $user->last_name }}
						</td>
						<td>
						{{ $user->email }}
						</td>
						<td>
						{{ $user->group[0]->name }}
						</td>
		      </tr>
		    @endforeach
		    </tbody>
	    </table>
	  @else
	   	<i>No Users</i>
	  @endif
@stop
