<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Group extends Eloquent
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';
    public $validator;

    public function getByPage($page = 1, $limit = 40)
    {
        $results = new stdClass();
        $results->page = $page;
        $results->limit = $limit;
        $results->totalItems = 0;
        $results->items = array();

        $users = $this->getSearch($page, $limit);

        $results->totalItems = $this->count();
        $results->items = $users->all();

        return $results;
    }

    public function getSearch($page = 1, $limit = 9999999)
    {
        $params = Input::except('page');

        if (count($params) > 0) {
            Session::put('search.groups', $params);
        } elseif (Session::has('search.groups')) {
            $params = Session::get('search.groups');
        }

        $groups = self::whereRaw('1');

        if (array_key_exists('name', $params) && !empty($params['name'])) {
            $groups->where('name', 'like', '%'.$params['name'].'%');
        }

        $groups->skip($limit * ($page - 1))->take($limit);

        return $groups->get();
    }

    // satisfy the group requirements and create a new group
    // return the new group id
    public function createGroup($data)
    {
        $rules = array(
                                'name' => 'required|unique:groups',
                                'permissions' => 'required',
                            );

        $this->validator = Validator::make($data, $rules);

        if ($this->validator->fails()) {
            return false;
        } else {
            $group_permissions = $data['permissions'];
            $default_permissions = array('admin.dashboard' => 1, 'user.logout' => 1);
            array_merge($group_permissions, $default_permissions);
             // Create the group
             $group = new self();
            $group->name = $data['name'];
            $group->permissions = json_encode($group_permissions);
            $group->save();

            return $group->id;
        }
    }

    // Update a groups details using data validation
    // only use on a group thta has been loaded from the database ( group model must be populated so $this->id is valid )
    public function updateGroup($data)
    {
        $rules = array('name' => 'required|unique:groups,name,'.$this->id);
        if (array_key_exists('permissions', $data)) {
            $rules['permissions'] = 'required';
        }
        $this->validator = Validator::make($data, $rules);

        if ($this->validator->fails()) {
            return false;
        } else {
            $this->name = $data['name'];
            if (array_key_exists('permissions', $data)) {
                $this->permissions = json_encode($data['permissions']);
            }
            $this->save();

            return true;
        }
    }

    // Use this function to satisfy any dependances based on relationships if required
    // can do validation to ensure the value is not in use before deleting
    public function delete()
    {
        $count = UserGroup::where('group_id', $this->id)->count();

        if ($count == 0) {
            parent::delete();

            return true;
        } else {
            // TODO - provide an error message
            return false;
        }
    }
}
