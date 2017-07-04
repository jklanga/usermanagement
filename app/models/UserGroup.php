<?php

class UserGroup extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups';
    protected $guarded = array();
    public $timestamps = false;

    public function validate($input)
    {
        $rules = array(
        );

        return Validator::make($input, $rules);
    }

    public function assignGroup($data)
    {
        // Create the user group
         $user_group = new self();
        $user_group->user_id = $data['user_id'];
        $user_group->group_id = $data['group_id'];
        $user_group->save();

        return true;
    }

    public function delete()
    {
        $count = User::where('id', $this->user_id)->count();

        if ($count == 0) {
            $this->delete();

            return true;
        } else {
            // TODO - provide an error message
            return false;
        }
    }
}
