<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use App\Http\Controllers\LessonsController;
use App\Models\Auth\User;
use App\Models\Stripe\SubscribeCourse;
//use App\Models\stripe\UserCourses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Stripe\UserCourses;
use DB;
use Illuminate\Support\Facades\Storage;

class CourseModuleWeightage extends Model
{
    protected $fillable = [
        'course_id',
        'minimun_qualify_marks',
        'weightage',
        'last_module'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
