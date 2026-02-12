<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentStatusRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return StudentResource::collection($students);
    }


    public function store(StudentCreateRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;
        
        if ($request->hasFile('profile_image')) {
            $uploadedFile = $request->file('profile_image');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            // Check if any existing student has the same image
            $existingStudent = Student::whereNotNull('profile_image')
                ->get()
                ->first(function ($student) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $student->profile_image);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingStudent) {
                $imagePath = $existingStudent->profile_image;
            } else {
                $imagePath = $uploadedFile->store('profile', 'public');
            }
        }

        $student = new Student();
        $student->student = $data['student'];
        $student->email = $data['email'];
        $student->profile_image = $imagePath;
        $student->course = $data['course'];
        $student->applied_university = $data['applied_university'];
        $student->status = $data['status'];
        $student->application = $data['application'];
        $student->counselor = $data['counselor'];

        $student->save();

        return new StudentResource($student);
    }

   
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    
    public function update(StudentUpdateRequest $request, Student $student)
    {
        $data = $request->validated();
        
        if ($request->hasFile('profile_image')) {
            $uploadedFile = $request->file('profile_image');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            // Check if any existing student has the same image
            $existingStudent = Student::whereNotNull('profile_image')
                ->where('id', '!=', $student->id)
                ->get()
                ->first(function ($student) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $student->profile_image);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingStudent) {
                $student->profile_image = $existingStudent->profile_image;
            } else {
                $student->profile_image = $uploadedFile->store('profile', 'public');
            }
        }

        $student->student = $data['student'];
        $student->email = $data['email'];
        $student->course = $data['course'];
        $student->applied_university = $data['applied_university'];
        $student->status = $data['status'];
        $student->application = $data['application'];
        $student->counselor = $data['counselor'];

        $student->save();
        
        return new StudentResource($student);
    }

   
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }

    public function studentStatus(StudentStatusRequest $request, Student $student)
    {
        $data = $request->validated();
         
        $student->update($data);

        return new StudentResource($student);
    }
}
