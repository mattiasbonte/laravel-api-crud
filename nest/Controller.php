<?php

namespace App\Http\Controllers;

use App\Models\BASE_Upper_singular;
use App\Models\NEST_Upper_singular;
use App\Http\Requests\BASE_Upper_singularRequest;
use App\Http\Resources\BASE_Upper_singularResource;

class BASE_Upper_singularController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(BASE_Upper_singular::class, 'BASE_lower_singular');
    }

    /**
     * Display a listing of the resource.
     *
     * @param NEST_Upper_singular $NEST_lower_singular The NEST_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NEST_Upper_singular $NEST_lower_singular)
    {
        if (true) { // TODO CRUD ADD AUTH CHECK HERE
            return BASE_Upper_singularResource::collection($NEST_lower_singular->BASE_lower_plural);
        }

        return abort(403, "Unauthorized: You can not create a new BASE_lower_singular for this NEST_lower_singular");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NEST_Upper_singular    $NEST_lower_singular The NEST_lower_singular
     * @param BASE_Upper_singularRequest $request The request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NEST_Upper_singular $NEST_lower_singular, BASE_Upper_singularRequest $request)
    {
        if (true) { // TODO CRUD ADD AUTH CHECK HERE
            return new BASE_Upper_singularResource($NEST_lower_singular->BASE_lower_plural()->create($request->validated()));
        }

        return abort(403, "Unauthorized: You can not create a new BASE_lower_singular for this NEST_lower_singular");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BASE_lower_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function show(BASE_Upper_singular $BASE_lower_singular)
    {
        return new BASE_Upper_singularResource($BASE_lower_singular);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BASE_Upper_singularRequest $request The request
     * @param BASE_Upper_singular        $BASE_lower_singular     The BASE_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BASE_Upper_singularRequest $request, BASE_Upper_singular $BASE_lower_singular)
    {
        $BASE_lower_singular->update($request->validated());

        return new BASE_Upper_singularResource($BASE_lower_singular);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(BASE_Upper_singular $BASE_lower_singular)
    {
        $BASE_lower_singular->delete();

        return response()->json(
            [
                'message' => 'BASE_Upper_singular deleted.',
                'NEST_lower_singular' => new BASE_Upper_singularResource($BASE_lower_singular)
            ]
        );
    }
}
