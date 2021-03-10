<?php

namespace App\Http\Controllers\Business\Jobs;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //

    protected const DATA = [
        'title',
        'company',
        'location',
        'description',
        'type',
        'category',
        'work_condition',
        'salary_range',
        'deadline'
    ];

    public function index()
    {
        $records_per_page = 14;
        $data = auth()->user()->jobs()->paginate($records_per_page);
        return JobResource::collection($data);

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string|in:' . implode(',', Job::JOB_TYPES),
            'category' => 'required|string|in:' . implode(',', Job::JOB_CATEGORIES),
            'work_condition' => 'required|string|in:' . implode(',', Job::WORK_CONDITIONS),
            'salary_range' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d'
        ]);

        $business = auth()->user();
        $business->jobs()->create($request->only(static::DATA));

        return response()->json([
            'status' => 'success',
            'message' => 'Job successfully created'
        ]);
    }

    public function update(Request $request, $job_id)
    {
        $business = auth()->user();
        $request->validate([
            'title' => 'filled|string',
            'company' => 'filled|string',
            'location' => 'filled|string',
            'description' => 'filled|string',
            'type' => 'filled|string|in:' . implode(',', Job::JOB_TYPES),
            'category' => 'filled|string|in:' . implode(',', Job::JOB_CATEGORIES),
            'work_condition' => 'filled|string|in:' . implode(',', Job::WORK_CONDITIONS),
            'salary_range' => 'filled|string',
            'deadline' => 'filled|date_format:Y-m-d'
        ]);

        $job = $business->jobs()->findOrFail($job_id);
        $job->update($request->only(static::DATA));

        return response()->json([
            'status' => 'success',
            'message' => 'Job successfully updated'
        ]);
    }

    public function delete($job_id)
    {
        $business = auth()->user();
        $business->jobs()->findOrFail($job_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Job successfully deleted'
        ]);
    }
}
