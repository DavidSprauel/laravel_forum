<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\User;

class Notification extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\Notification();
        $this->write = new \Forum\Models\DataAccess\Write\Notification();
    }
    
    public function markAsRead(User $user, $notificationId) {
        return $this->write->markAsRead($user, $notificationId);
    }
    
    public function fetchUnreadNotifications(User $user) {
        return $this->read->fetchUnreadNotifications($user);
    }
}