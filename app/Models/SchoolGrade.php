<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolGrade extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table   = 'school_grades';
    protected $guarded = [];

    /* relations */

    public function level()
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    /* scopes */

    public function scopeSearch($query)
    {
        return $query->when(request()->filled('search'), function($query){
            $query->where('name', 'LIKE', '%'.request()->search.'%');
        });
    }
    
    public function scopeLevelId($query)
    {
        return $query->when(request()->filled('level_id'), function($query){
            $query->where('level_id', request()->level_id );
        });
    }

}
