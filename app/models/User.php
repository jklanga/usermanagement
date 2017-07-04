<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait, SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];
    protected $guarded = ['id', 'password'];
    protected $softDelete = true;

    private $passwordRules = [];
    public $validator;

    public function setPasswordRules()
    {
      $this->passwordRules = [
        'password' => 'required|alpha_num|min:5|confirmed',
        'password_confirmation' => 'required|alpha_num|min:5',
      ];
    }

    public function validate($input)
    {
      $rules = array_merge(
        [
          'first_name' => 'required',
          'last_name' => 'required',
          'email' => 'email|unique:users,email,'.$this->id.'|required',
        ], 
        $this->passwordRules
      );

      return Validator::make($input, $rules);
    }
    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function group()
    {
      return $this->belongsToMany('Group', 'users_groups');
    }

    public function getUsers()
    {
      return self::get();
    }

    public function createUser($data)
    {
      $this->validator = $this->validate($data);

      if ($this->validator->fails()) {
        return false;
      } else {
        Sentry::getUserProvider()->create(
          [
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'activated' => 1,
          ]
        );

        $user = Sentry::getUserProvider()->findByLogin($data['email']);
        $this->id = $user->id;

        if (array_key_exists('group_id', $data)) {
            $group = Sentry::getGroupProvider()->findById($data['group_id']);
            $user->addGroup($group);
        }

        return true;
      }
    }

    public function updateUser($data)
    {
      $this->validator = $this->validate($data);

      if ($this->validator->fails()) {
        return false;
      } else {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        if (array_key_exists('password', $data)) {
            $this->password = Hash::make($data['password']);
        }

        $this->save();

        if (array_key_exists('group_id', $data)) {
          $user = Sentry::getUserProvider()->findById($this->id);
          $groups = $user->getGroups();

          foreach ($groups as $g) {
              $user->removeGroup($g);
          }

          $group = Sentry::getGroupProvider()->findById($data['group_id']);
          $user->addGroup($group);
        }

        return true;
      }
    }

    public function groupAssigned($group)
    {
      $userGroups = $this->group;
      foreach ($userGroups as $userGroup) {
        if ($userGroup->id == $group->id) {
          return true;
        }
      }

      return false;
    }

    public function lastSeen($email)
    {
      $lastLogin = DB::table($this->table)
        ->where('email', '=', $email)
        ->whereRaw('last_login IS NOT NULL')
        >get(['last_login']);

      if (count($lastLogin) > 0) {
        return $lastLogin[0];
      } else {
        return null;
      }
    }

    public function lastLoginUser()
    {
      $user = DB::table($this->table)
        ->whereRaw('last_login = (SELECT MAX(last_login) FROM users)')
        ->get();

      if (count($user) > 0) {
        return $user[0];
      } else {
        return null;
      }
    }

    public function delete()
    {
      if ($this->delete()) {
        UserGroup::where('user_id', '=', $this->id)->delete();
        return true;
      } else {
        //@TODO - provide an error message
        return false;
      }
    }
}
