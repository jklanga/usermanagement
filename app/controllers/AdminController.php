<?php

class AdminController extends BaseController
{
    protected $layout = 'layouts.admin';
    public $activityTypes = ['LOGIN', 'CREATE', 'UPDATE', 'DELETE', 'LOGOUT'];

    public function __construct()
    {
        $data['currentUser'] = Sentry::getUser();
        View::share($data);
    }

    public function listActivityLogs()
    {
      $activityLogs = (new ActivityLog())->getActivityLogs();
      $users = User::get();

      $this->layout->content = View::make('admin.activitylogs.list')
          ->with(
            [
              'activityLogs' => $activityLogs, 
              'activityTypes' => $this->activityTypes, 
              'users' => $users, 
              'r' => 2
            ]
          );
    }

    public function getViewLog()
    {
      $id = Input::get('id');

      if (!empty($id)) {
          $log = ActivityLog::find($id);
      } else {
          Session::flash('fail', 'Log not found!');
          return Redirect::to('admin/listActivityLogs');
      }
      $log->convertData();
      $this->layout->content = View::make('admin.activitylogs.view')->with('log', $log);
    }
}
