<!-- Fixed navbar -->
<div class="navbar navbar-fixed-top" role="navigation">
    <div class="navbar-header">
      <h3>Kuthula Langa's Test :: </h3>&nbsp;
    </div>
    <div class="navbar-collapse collapse">
	    @if(Sentry::check())
		    <ul class="nav navbar-nav">
					<ul class="nav nav-pills">
						<li class="active">{{ HTML::link('/home','Dashboard') }}</li>
						<li>{{ HTML::link('/admin/users','Users') }}</li>
						<li>{{ HTML::link('/admin/activitylogs','Activity Logs') }}</li>
						<li>{{ HTML::link('/user/logout','Logout') }}</li>
					</ul>
		    </ul>
		@endif
    </ul>
    </div><!--/.nav-collapse -->
</div>