<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrganizationResource;
use App\Http\Controllers\API\BaseController as BaseController;

class OrganizationController extends BaseController
{
    public function index(Request $request)
    {
        $organizations = Organization::when($request->filled('search'),function($org)use ($request
        ){
           $org->where('org_name','LIKE','%'.$request->search.'%')
           ->orWhere ('description','LIKE','%'.$request->search.'%');
        })->paginate($request->per_page);
      
        return $this->sendResponse(($organizations),
         'Organizations retrieved successfully!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
     
        $request->validate( [
            'org_name' => 'required|unique:organizations',
            'description' => 'required'
        ]);
     
        $organization = Organization::create($request->all());
     
        return $this->sendResponse(new OrganizationResource($organization), 'Organization Created Successfully!');
   
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::find($id);
    
        if (is_null($organization)) {
            return $this->sendError('Organization not found!');
        }
     
        return $this->sendResponse(new OrganizationResource($organization), 'Organization Retrieved Successfully!');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'org_name' => 'required|unique:organizations',
            'description' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Error organization name or description!', $validator->errors());       
        }
     
        $organization->org_name = $input['org_name'];
        $organization->description = $input['description'];
        $organization->save();
     
        return $this->sendResponse(new OrganizationResource($organization), 'Organization Updated Successfully!');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
     
        return $this->sendResponse([], 'Organization Deleted Successfully!');
    }
}
