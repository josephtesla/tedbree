<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'type',
        'category',
        'salary_range',
        'deadline'
    ];

    public const JOB_TYPES = [
        'full-time', 'temporary', 'contract', 'permanent', 'internship', 'volunteer'
    ];

    public const JOB_CATEGORIES = [
        'tech', 'health_care', 'hospitality', 'customer', 'service', 'marketing'
    ];

    public const WORK_CONDITIONS = [
        'remote', 'part-remote', 'on-premise'
    ];

    public function applications(){
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
