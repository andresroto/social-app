<?php

namespace App\Http\Controllers;

use App\Events\StatusCreated;
use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

class StatusController extends Controller
{   

    public function index()
    {
        return StatusResource::collection(Status::orderBy('id', 'DESC')->paginate()); 
    }

    public function show(Status $status)
    {
        return view('statuses.show', [
            'status' => StatusResource::make($status)
        ]); 
    }
    
    public function store(Request $request)
    {
        $validStatus = $this->validate($request, [
            'body' => 'required|min:5'
        ]); 
        
        $status = $request->user()->statuses()->create($validStatus); 

        $statusResource = StatusResource::make($status); 

        StatusCreated::dispatch($statusResource); 

        return $statusResource; 
    }
}
