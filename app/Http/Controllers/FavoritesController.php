<?php

namespace Forum\Http\Controllers;

use DB;
use Forum\Models\Business\Favorite;
use Forum\Models\Entities\Eloquent\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
        $this->favoriteBusiness = new Favorite();
    }
    
    public function store(Reply $reply) {
        $this->favoriteBusiness->store($reply);
        
        return back();
    }
    
    public function destroy(Reply $reply) {
        $this->favoriteBusiness->delete($reply);
    }
}
