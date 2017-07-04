<?php

class UserController extends BaseController
{
    protected $layout = 'layouts.admin';

    public function __construct()
    {
      $data['currentUser'] = Sentry::getUser();
      View::share($data);
    }

    public function login()
    {
      $email = Input::get('email');
      $credentials = [
          'email' => $email,
          'password' => Input::get('password'),
      ];

      try {
        $user = new User();
        $lastLoginUser = $user->lastLoginUser();
        $lastSeen = $user->lastSeen($email);

        Session::put('lastLoginUser', $lastLoginUser);
        Session::put('lastSeen', $lastSeen);

        $user = Sentry::authenticate($credentials, true);
        if ($user) {
            $activityLog = new ActivityLog();
            $activityLog->log('Login', $user);

            Notification::success('Login Successful.');

            return Redirect::to('/home');
        }
      } catch (\Exception $e) {
          return Redirect::to('/')->withErrors($e->getMessage());
      }
    }

    public function listUsers()
    {
      $page = Input::get('page', 1);
      $page_size = 10;

      $user = new User();
      $groups = Group::orderBy('name')->get();
      $users = $user->getUsers();
      $data_before_edit = base64_encode(json_encode((array) $users->all()));

      $this->layout->content = View::make('admin.users.list')->with(
        [
          'users' => $users, 
          'groups' => $groups, 
          'data_before_edit' => $data_before_edit
        ]
      );
    }

    public function showEditUser()
    {
      $pageData = [];
      $userId = Input::get('id');

      if (Request::isMethod('post')) {
          $user = new User();
          $formData = [
              'first_name' => Input::get('first_name'),
              'last_name' => Input::get('last_name'),
              'email' => Input::get('email'),
              'group_id' => Input::get('group_id'),
          ];

          if (empty($userId)) {
              $formData['password'] = Input::get('password');
              $formData['password_confirmation'] = Input::get('password_confirmation');

              $user->setPasswordRules();

              if (!$user->createUser($formData)) {
                  return Redirect::route('admin.user.edit')->withErrors($user->validator)->withInput();
              }

              Session::flash('success', 'Successfully created.');
          } else {
              $user = User::find($userId);
              $formData['id'] = $userId;
              $password = Input::get('password');

              if (!empty($password)) {
                  $formData['password'] = $password;
                  $formData['password_confirmation'] = Input::get('password_confirmation');
                  $user->setPasswordRules();
              }

              if (!$user->updateUser($formData)) {
                  return Redirect::route('admin.user.edit', 'id='.$userId)->withErrors($user->validator)->withInput();
              }

              Session::flash('success', 'User information was updated.');
          }

          if (Sentry::check()) {
              return Redirect::route('admin.user.edit', 'id='.$userId);
          } else {
              return Redirect::to('/');
          }
      }

      if (!empty($userId)) {
          $user = User::where('id', '=', $userId)->get();
          $pageData['data_before_edit'] = base64_encode(json_encode(($user[0]['attributes'])));
          $pageData['user'] = $user[0];
      }

      $pageData['groups'] = Group::orderBy('name')->get();

      $this->layout->content = View::make('admin.users.edit')->with($pageData);
    }

    public function getLogout()
    {
        (new ActivityLog())->log('Logout', User::find(Sentry::getUser()->id));

        Sentry::logout();
        Session::flush();

        return Redirect::to('/');
    }
}
