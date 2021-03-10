<?php

namespace App\Http\Controllers\Guest\Jobs;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    protected const DATA = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
    ];

    public function index(Request $request)
    {
        $records_per_page = 4;
        $data = Job::query();

        foreach (['title', 'location'] as $filter) {
            if ($request->input($filter)) {
                $data = $data->where($filter, 'like', '%' . $request->input($filter) . '%');
            }
        }
        return JobResource::collection($data->paginate($records_per_page));

    }

    public function show($job_id)
    {
        return new JobResource(Job::findOrFail($job_id));
    }

    public function apply(Request $request, $job_id)
    {
        $job = Job::findOrFail($job_id);
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|min:11',
            'location' => 'required|string',
            'cv' => 'required|file|mimes:pdf,docx,doc'
        ]);

        $path = '';
        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $file = $request->file('cv');
            $path = $file->storePublicly('uploads/cvs');
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid CV submitted'
            ]);
        }

        $job->applications()->updateOrCreate(['email' => $request->input('email')], $request->only(static::DATA) + ['cv_path' => $path]);

        return response()->json([
            'status' => 'success',
            'message' => 'Job successfully applied'
        ]);
    }
}
