<?php


namespace Forum\Models\DataAccess\Write;


class Activity extends BaseWriter {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Activity::class;
    }
    
    public function createOne($subject, $data) {
        return $subject->activity()->create($data);
    }
}