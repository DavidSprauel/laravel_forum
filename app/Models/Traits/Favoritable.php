<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 17/11/2017
 * Time: 08:59
 */

namespace Forum\Models\Traits;


use Forum\Models\Entities\Eloquent\Favorite;

trait Favoritable {
    
    public function favorites() {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    
    public function favorite() {
        $attributes = ['user_id' => auth()->id()];
        
        if(!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }
    
    public function isFavorited() {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }
    
    public function getFavoritesCountAttribute() {
        return $this->favorites->count();
    }
}