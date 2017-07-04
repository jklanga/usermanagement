<?php

class ModelObserver
{
    public function created($model)
    {
        $activity_log = new ActivityLog();
        $activity_log->log('Create', $model);
    }

    public function updated($model)
    {
        $activity_log = new ActivityLog();
        $activity_log->log('Update', $model);
    }

    public function deleted($model)
    {
        $activity_log = new ActivityLog();
        $activity_log->log('Delete', $model);
    }
}
