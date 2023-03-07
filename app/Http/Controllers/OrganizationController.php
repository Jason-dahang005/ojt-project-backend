<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = Organization::where('user_id', auth()->id())->get();

        if($organization){
            return response()->json([
                'organization' => $organization
            ]);
        } else {
            return response()->json([
                'message' => 'no organization found'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|unique:organizations',
            'description'   => 'required'
        ]);


        $organization = new Organization;
        $organization->name          = $request->name;
        $organization->description   = $request->description;
        $organization->user_id       = auth()->id();
        $organization->save();

        return response()->json([
            'organization'  => $organization,
            'message'       => 'Organization Successfully Created!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization, Request $request)
    {
        $organization =  Organization::find($request->id);

        if($organization){
            return response()->json([
                'status'        => 'success',
                'organization'  => $organization
            ]);
        } else {
            return response()->json([
                'message' => 'no organization found'
            ]);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
