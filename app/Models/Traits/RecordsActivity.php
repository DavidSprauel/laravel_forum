<?php


namespace Forum\Models\Traits;


use Forum\Models\Business\Activity as ActivityBusiness;
use Forum\Models\Entities\Eloquent\Activity;

trait RecordsActivity {
    
    protected static function bootRecordsActivity() {
        if(auth()->guest()) return;
        
        foreach(static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event){
                $model->recordActivity($event);
            });
        }
    }
    
    protected static function getActivitiesToRecord() {
        return ['created', 'deleted', 'updated'];
    }
    
    protected function recordActivity($event) {
        $activityBusiness = new ActivityBusiness();
        $activityBusiness->create($this, [
            'user_id'      => auth()->id(),
            'type'         => $this->getActivityType($event),
        ]);
    }
    
    protected function getActivityType($event): string {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        
        return "{$event}_{$type}";
    }
    
    public function activity() {
        return $this->morphMany(Activity::class, 'subject');
    }
    
}