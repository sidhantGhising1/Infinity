<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultancyCreateRequest;
use App\Http\Requests\ConsultancyStatusRequest;
use App\Http\Requests\ConsultancyUpdateRequest;
use App\Http\Resources\ConsultancyResource;
use App\Models\Consultancy;
use Illuminate\Http\Request;

class ConsultancyController extends Controller
{
    public function index()
    {
        $consultancies = Consultancy::all();
        return ConsultancyResource::collection($consultancies);
    }


    public function store(ConsultancyCreateRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;

        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            $existingConsultancy = Consultancy::whereNotNull('logo')
                ->get()
                ->first(function ($consultancy) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $consultancy->logo);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingConsultancy) {
                $imagePath = $existingConsultancy->logo;
            } else {
                $imagePath = $uploadedFile->store('consultancy', 'public');
            }
        }

        $consultancy = new Consultancy();
        $consultancy->logo = $imagePath;
        $consultancy->consultancy_name = $data['consultancy_name'];
        $consultancy->email = $data['email'];
        $consultancy->phone = $data['phone'];
        $consultancy->country = $data['country'];
        $consultancy->service_fee = $data['service_fee'];
        $consultancy->currency = $data['currency'];
        $consultancy->students = $data['students'];
        $consultancy->status = $data['status'];

        $consultancy->save();

        return new ConsultancyResource($consultancy);
    }

   
    public function show(Consultancy $consultancy)
    {
        return new ConsultancyResource($consultancy);
    }

    
    public function update(ConsultancyUpdateRequest $request, Consultancy $consultancy)
    {
        $data = $request->validated();
        
        if ($request->hasFile('logo')) {
            $uploadedFile = $request->file('logo');
            
            $fileHash = md5_file($uploadedFile->getRealPath());
            
            $existingConsultancy = Consultancy::whereNotNull('logo')
                ->where('id', '!=', $consultancy->id)
                ->get()
                ->first(function ($consultancy) use ($fileHash) {
                    $existingPath = storage_path('app/public/' . $consultancy->logo);
                    if (file_exists($existingPath)) {
                        return md5_file($existingPath) === $fileHash;
                    }
                    return false;
                });
            
            if ($existingConsultancy) {
                $consultancy->logo = $existingConsultancy->logo;
            } else {
                $consultancy->logo = $uploadedFile->store('consultancy', 'public');
            }
        }

        $consultancy->consultancy_name = $data['consultancy_name'];
        $consultancy->email = $data['email'];
        $consultancy->phone = $data['phone'];
        $consultancy->country = $data['country'];
        $consultancy->service_fee = $data['service_fee'];
        $consultancy->currency = $data['currency'];
        $consultancy->students = $data['students'];
        $consultancy->status = $data['status'];

        $consultancy->save();
        
        return new ConsultancyResource($consultancy);
    }

   
    public function destroy(Consultancy $consultancy)
    {
        $consultancy->delete();
        return response()->noContent();
    }

     public function consultancyStatus(ConsultancyStatusRequest $request, Consultancy $consultancy)
    {
        $data = $request->validated();
         
        $consultancy->update($data);

        return new ConsultancyResource($consultancy);
    }
}
