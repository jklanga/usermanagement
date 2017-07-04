@include('notifications')

<div class="container">

	<div class="row">
		<div class="center-block" style="width: 400px; padding-top: 100px">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Login</h3>
				</div>
				<div class="panel-body">
				
					{{ Form::open(array('url' => 'user/login', 'role' => 'form', 'class' => 'form-horizontal')) }}
					<div class="form-group">
						{{ Form::label('email', 'Email', array('class' => 'col-sm-4 control-label login-label')) }}
						<div class="col-sm-8">
							{{ Form::text('email', '', array('class' => 'form-control')) }}
						</div>
					</div>
						
					<div class="form-group">
						{{ Form::label('password', 'Password', array('class' => 'col-sm-4 control-label login-label')) }}
						<div class="col-sm-8">
							{{ Form::password('password', array('class' => 'form-control')) }}
						</div>
					</div>
						
					<div class="form-group">
						<div align="center">
						
							{{ Form::submit('Login', array('class' => 'btn btn-default btn-lg')) }}
							<br /><div class="clear"></div>
							{{ link_to('user/signup', 'Sign Up', $attributes = array(), $secure = null) }}
							
						</div>
					</div>
					{{ Form::close() }}
				
				</div>
			</div>
		</div>
	</div>

</div><!-- end main content div -->

