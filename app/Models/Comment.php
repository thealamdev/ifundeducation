<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->whereNotNull('parent_id');
    }

    public function fundraiserpost() {
        return $this->belongsTo(FundraiserPost::class, 'fundraiser_post_id');
    }
    public function author() {
        return $this->hasOne(User::class);
    }
}