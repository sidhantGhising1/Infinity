<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniversityCreateRequest;
use App\Http\Requests\UniversityStatusRequest;
use App\Http\Requests\UniversityUpdateRequest;
use App\Http\Resources\UniversityResource;
use App\Models\University;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::all();
        return UniversityResource::collection($universities);
    }


    public function store(UniversityCreateRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;

        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            $existingUniversity = University::whereNotNull('logo')
                ->get()
                ->first(function ($university) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $university->logo);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingUniversity) {
                $imagePath = $existingUniversity->logo;
            } else {
                $imagePath = $uploadedFile->store('university', 'public');
            }
        }

        $university = new University();
        $university->logo = $imagePath;
        $university->university_name = $data['university_name'];
        $university->country = $data['country'];
        $university->city = $data['city'];
        $university->partner_type = $data['partner_type'];
        $university->programs = $data['programs'];
        $university->application_fee = $data['application_fee'];
        $university->status = $data['status'];

        $university->save();

        return new UniversityResource($university);
    }

   
    public function show(University $university)
    {
        return new UniversityResource($university);
    }

    
    public function update(UniversityUpdateRequest $request, University $university)
    {
        $data = $request->validated();
        
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            $existingUniversity = University::whereNotNull('logo')
                ->where('id', '!=', $university->id)
                ->get()
                ->first(function ($university) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $university->logo);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingUniversity) {
                $university->logo = $existingUniversity->logo;
            } else {
                $university->logo = $uploadedFile->store('university', 'public');
            }
        }

        $university->university_name = $data['university_name'];
        $university->country = $data['country'];
        $university->city = $data['city'];
        $university->partner_type = $data['partner_type'];
        $university->programs = $data['programs'];
        $university->application_fee = $data['application_fee'];
        $university->status = $data['status'];

        $university->save();
        
        return new UniversityResource($university);
    }

   
    public function destroy(University $university)
    {
        $university->delete();
        return response()->noContent();
    }

    public function universityStatus(UniversityStatusRequest $request, University $university)
    {
        $data = $request->validated();
         
        $university->update($data);

        return new UniversityResource($university);
    }
}
