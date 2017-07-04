<?php

class HomeController extends BaseController
{
    protected $layout = 'layouts.public';

    public function __construct()
    {
        $data['currentUser'] = Sentry::getUser();
        View::share($data);
    }

    public function login()
    {
        $this->layout->content = View::make('public.body.login');
    }

    public function home()
    {
        $pageData = [
          'activityLogs' => (new ActivityLog())->getActivityLogs(),
          'lastLogin' => Session::get('last_login_user'),
          'lastSeen' => Session::get('last_seen')
        ];

        $this->layout->content = View::make('public.body.home')->with($pageData);
    }
}
