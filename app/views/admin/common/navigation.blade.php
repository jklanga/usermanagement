<!-- Fixed navbar -->
    <div class="navbar navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <h3>Admin :: </h3>&nbsp;&nbsp;
        </div>
        <div class="navbar-collapse collapse">
          @if(Sentry::check())
	          <ul class="nav navbar-nav">
	            <ul class="nav nav-pills">
							<li class="">{{ HTML::link('/home','Dashboard') }}</li>
							</li>
							<li>{{ HTML::link('/admin/users','Users') }}</li>
							<li>{{ HTML::link('/admin/activitylogs','Activity Logs') }}</li>
							<li>{{ HTML::link('/user/logout','Logout') }}</li>
				    </ul>
					@endif
          </ul>
        </div><!--/.nav-collapse -->
    </div>