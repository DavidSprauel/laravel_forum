<?php


namespace Forum\Models\DataAccess\Read;


class Activity extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Activity::class;
    }
}