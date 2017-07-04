<hr>
<div class="container">
	<div class="row">
		<div class="col-sm-6"><h3><span class="label label-default">{{$currentUser->first_name." ".$currentUser->last_name}}</span></h3></div>
  </div>
  <div class="row">
		<div class="col-sm-4">
      <ul class="list-group">
        <li class="list-group-item text-muted">Profile</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Joined :</strong></span> {{$currentUser->created_at}}</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Last seen :</strong></span> @if(isset($lastSeen) && !empty($lastSeen)){{date(" D, d M Y @ H:i:s",strtotime($lastSeen->last_login))}}@elseif($lastSeen == NULL) Now @else :: @endif</li>
      </ul>
      <ul class="list-group">
        <a class="list-group-item active"><label>Last Logged In User</label></a>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Name : </strong></span> @if(isset($lastLogin) && !empty($lastLogin)){{$lastLogin->first_name." ".$lastLogin->last_name}}@else You @endif</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Date : </strong></span> @if(isset($lastLogin) && !empty($lastLogin)){{date(" D, d M Y @ H:i:s",strtotime($lastLogin->last_login))}}@else Now @endif</li>
      </ul>
    </div>
  	<div class="col-sm-7">
      <div class="tab-content">
        <div class="tab-pane active" id="home">
          <hr>
          <h4>Recent Activities</h4>
          <div class="table-responsive">
            <table class="table table-hover">
              <tbody>
                @foreach($activityLogs as $log)
		    	        <tr>
                    <td><i class="pull-right fa fa-edit"></i> {{$log->created_at}} - {{$log->description}}.</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
         </div><!--/tab-pane-->
        </div><!--/tab-pane-->
      </div><!--/tab-content-->
    </div><!--/col-9-->
  </div><!--/row-->

