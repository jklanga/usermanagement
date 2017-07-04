<?php

use App\Models\User;

class SentrySeeder extends Seeder {

	public function run()
	{
	    DB::table('users')->truncate();
	    DB::table('groups')->truncate();
	    DB::table('users_groups')->truncate();
	
	    Sentry::getUserProvider()->create(array(
	        'email'       => 'jklanga@gmail.com',
	        'password'    => "12345",
	        'first_name'  => 'Kuthula',
	        'last_name'   => 'Langa',
	        'activated'   => 1,
		    )
		);
		
		Sentry::getUserProvider()->create(array(
		        'email'       => 'joyful_kl@yahoo.com',
		        'password'    => "54321",
		        'first_name'  => 'Joyful',
		        'last_name'   => 'Sun',
		        'activated'   => 1,
		    )
		);
		
		// Assign user permissions
	    Sentry::getGroupProvider()->create(array(
	        'name'        => 'Admin',
	        'permissions' => array('admin.*' => 1, 'user.*' => 1),
	    ));
		Sentry::getGroupProvider()->create(array(
	        'name'        => 'User',
	        'permissions' => array('admin.*' => 0, 'user.*' => 1),
	    ));
	
	    // Add User groups
	    $adminUser  = Sentry::getUserProvider()->findByLogin('jklanga@gmail.com');
	    $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
	    $adminUser->addGroup($adminGroup);
		
		$adminUser  = Sentry::getUserProvider()->findByLogin('joyful_kl@yahoo.com');
	    $adminGroup = Sentry::getGroupProvider()->findByName('User');
	    $adminUser->addGroup($adminGroup);
	}

}