<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Notification;
use Forum\Models\Entities\Eloquent\Notification as NotificationModel;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller {
    
    protected $notificationBusiness;
    
    public function __construct() {
        $this->middleware('auth');
        $this->notificationBusiness = new Notification();
    }
    
    public function index(User $user) {
        return $this->notificationBusiness->fetchUnreadNotifications($user);
    }
    
    public function destroy(User $user, $notificationId) {
        return $this->notificationBusiness->markAsRead($user, $notificationId);
    }
}
