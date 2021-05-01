<?php

namespace App\Http\Controllers;

use App\Models\NEST_Upper_singular;
use App\Models\BASE_Upper_singular;
use App\Http\Requests\BASE_Upper_singularRequest;
use App\Http\Resources\BASE_Upper_singularResource;

class BASE_Upper_singularController extends Controller
{
    /**
     * Create a new BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\NEST_Upper_singular                $NEST_lower_singular   The NEST_lower_singular
     * @param \App\Http\Requests\BASE_Upper_singularRequest $validated The validated request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NEST_Upper_singular $NEST_lower_singular, BASE_Upper_singularRequest $validated)
    {
        $this->authorize('create', [new BASE_Upper_singular, $NEST_lower_singular]);

        return new BASE_Upper_singularResource($NEST_lower_singular->BASE_lower_plural()->create($validated->toArray()));
    }

    /**
     * Return all the BASE_lower_plural for the NEST_lower_singular.
     *
     * @param \App\Models\NEST_Upper_singular $NEST_lower_singular The NEST_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NEST_Upper_singular $NEST_lower_singular)
    {
        $this->authorize('viewAny', [new BASE_Upper_singular, $NEST_lower_singular]);

        return BASE_Upper_singularResource::collection($NEST_lower_singular->BASE_lower_plural);
    }

    /**
     * Return the specified BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The requested NEST_lower_singular
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function show(NEST_Upper_singular $NEST_lower_singular, BASE_Upper_singular $BASE_lower_singular)
    {

        $this->authorize('view', [$BASE_lower_singular, $NEST_lower_singular]);

        return new BASE_Upper_singularResource($BASE_lower_singular);
    }

    /**
     * Update the specified BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\NEST_Upper_singular                $NEST_lower_singular   The requested NEST_lower_singular
     * @param \App\Models\BASE_Upper_singular               $BASE_lower_singular  The requested BASE_lower_singular
     * @param \App\Http\Requests\BASE_Upper_singularRequest $validated The validated request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NEST_Upper_singular $NEST_lower_singular, BASE_Upper_singular $BASE_lower_singular, BASE_Upper_singularRequest $validated)
    {
        $this->authorize('update', [$BASE_lower_singular, $NEST_lower_singular]);

        $BASE_lower_singular->update($validated->toArray());

        return new BASE_Upper_singularResource($BASE_lower_singular);
    }

    /**
     * Delete the specified BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The requested NEST_lower_singular
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(NEST_Upper_singular $NEST_lower_singular, BASE_Upper_singular $BASE_lower_singular)
    {
        $this->authorize('delete', [$BASE_lower_singular, $NEST_lower_singular]);

        $BASE_lower_singular->delete();

        return response()->json(
            [
                'message' => 'BASE_Upper_singular deleted.',
                'BASE_lower_singular' => new BASE_Upper_singularResource($BASE_lower_singular)
            ]
        );
    }
}
