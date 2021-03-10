<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
        'cv_path'
    ];

    public function getCvAttribute(){
        return asset(str_replace('public', 'storage', $this->cv_path));
    }
}
