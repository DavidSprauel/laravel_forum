<?php
namespace Forum\Filters;

use Forum\Models\Business\User;
use Request;

class ThreadFilters extends Filters {
    
    protected $filters = ['by', 'popular', 'unanswered'];
    
    protected function by($username) {
        $userBusiness = new User;
        $user = $userBusiness->getByFirst(['name' => $username]);
        
        return $this->builder->where('user_id', $user->id);
    }
    
    protected function popular() {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
    
    protected function unanswered() {
        return $this->builder->where('replies_count', 0);
    }
    

}