<?php

namespace Forum\Models\DataAccess\Read;


use Forum\Models\Entities\Eloquent\User;

class Notification extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Notification::class;
    }
    
    public function fetchUnreadNotifications(User $user) {
        return $user->unreadNotifications;
    }
}