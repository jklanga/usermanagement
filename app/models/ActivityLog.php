<?php

class ActivityLog extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';
    protected $softDelete = true;
    protected $guarded = array();

    public function validate($input)
    {
        $rules = [];
        return Validator::make($input, $rules);
    }

    public function getActivityLogs()
    {
      return self::orderBy('created_at', 'DESC')->get();
    }

    public function log($type, $model)
    {
        if (Sentry::check()) {
            $this->user_id = Sentry::getUser()->id;
        } else {
            $this->user_id = 0;
        }
        $this->data = serialize(Input::except('password', 'password_confirmation'));
        $this->ip_address = Request::server('REMOTE_ADDR');
        $this->activity_type = $type;

        $description = '';
        switch (strtoupper($type)) {
            case 'LOGIN':
                $description = $this->login_description($model);
                break;
            case 'CREATE':
                $description = $this->insert_description($model);
                break;
            case 'UPDATE':
                $description = $this->edit_description($model);
                break;
            case 'DELETE':
                $description = $this->delete_description($model);
                break;
            case 'LOGOUT':
                $description = $this->logout_description($model);
                break;
            default:
                $description = 'no description';
                break;
        }
        $this->description = $description;

        $this->save();
    }

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function convertData()
    {
        $data = "LOG DATA:\n";
        foreach (unserialize($this->data) as $key => $value) {
            if (is_array($value)) {
                $data .= "{$key}: ".serialize($value)."\n";
            } else {
                $data .= "{$key}: {$value}\n";
            }
        }
        $this->data = $data;
    }

    public function login_description($model = array())
    {
        return $model->attributes['first_name'].' '.$model->attributes['last_name'].' logged in.';
    }

    public function insert_description($model = array())
    {
        $description = '|Insert '.ucwords(str_replace('_', ' ', $model['table']))." Record| \n";

        unset($model->attributes['updated_at']);
        foreach ($model->attributes as $key => $value) {
            $description .= ucwords(str_replace('_', ' ', $key))." = {$value} \n";
        }

        return $description;
    }

    public function edit_description($model = array())
    {
        $description = '|Edit '.ucwords(str_replace('_', ' ', $model['table']))." Record| \n";
        $data_before_edit = (array) json_decode(base64_decode(Input::get('data_before_edit')));
        if (array_key_exists('id', $data_before_edit) && $data_before_edit['id'] == $model->attributes['id']) {
            $old_data = $data_before_edit;
        } else {
            $old_data = (array) $this->get_old_data($data_before_edit, $model->attributes['id']);
        }

        unset($old_data['updated_at']);
        foreach ($model->attributes as $key => $value) {
            if (array_key_exists($key, $old_data)) {
                if ($old_data[$key] != $value) {
                    $description .= ucwords(str_replace('_', ' ', $key))." : FROM {$old_data[$key]} TO {$value} \n";
                }
            }
        }

        return $description;
    }

    public function get_old_data($old_data, $model_id)
    {
        foreach ($old_data as $key => $value) {
            if (is_object($value)) {
                if ($value->id == $model_id) {
                    return $old_data[$key];
                }
            }

            return array();
        }
    }

    public function delete_description($model = array())
    {
        $description = '|Delete '.ucwords(str_replace('_', ' ', $model['table']))." Record| \n";

        unset($model->attributes['updated_at']);
        foreach ($model->attributes as $key => $value) {
            $description .= ucwords(str_replace('_', ' ', $key))." = {$value} \n";
        }

        return $description;
    }

    public function logout_description($model = array())
    {
        return $model->attributes['first_name'].' '.$model->attributes['last_name'].' logged out.';
    }

    // Use this function to satisfy any dependances based on relationships if required
    // can do validation to ensure the value is not in use before deleting
    public function delete()
    {
        return $this->delete();
    }
}
