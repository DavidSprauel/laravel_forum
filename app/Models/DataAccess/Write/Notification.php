<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\User;

class Notification  extends BaseWriter {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Notification::class;
    }
    
    public function markAsRead(User $user, $notificationId) {
        return auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}