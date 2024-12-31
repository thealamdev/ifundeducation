<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicProfile extends Model {
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function classification() {
        return $this->hasOne( Classification::class, 'id', 'classification_id' );
    }

    public function enrolleddegree() {
        return $this->hasOne( DegreeEnrolled::class, 'id', 'degree_enrolled_id' );
    }

    public function university() {
        return $this->belongsTo( University::class );
    }
}