<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FundraiserPost extends Model {
    use HasFactory, SoftDeletes;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function fundraisercategory() {
        return $this->belongsTo(FundraiserCategory::class, 'fundraiser_category_id', 'id');
    }

    public function fundraiserupdatemessage() {
        return $this->hasMany(FundraiserUpdateMessage::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function donates() {
        return $this->hasMany(Donate::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pendingUpdate() {
        return $this->hasOne(FundraiserPostUpdate::class)->where('status', 'pending')->orderBy('id', 'desc');
    }

    public function reviewedComments() {
        return $this->hasMany(FundraiserApprovalComments::class)->where('status', 'reviewed');
    }
    public function blockComments() {
        return $this->hasMany(FundraiserApprovalComments::class)->where('status', 'block');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'end_date' => 'datetime',
    ];

}