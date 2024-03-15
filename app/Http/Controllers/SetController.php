<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;

class SetController extends Controller
{
    private function validInput(Request $data)
    {
        if ($data->method()==="POST") {
            return $data->validate([
                'name' => 'required|max:100|string',
                'released' => 'integer|min:1970|max:2024',
                'pieces' => 'required|integer|min:0',
                'rating' => 'required|integer|min:0|max:10',
                'description' => 'max:500|string',
                'owned' => 'required|boolean',
                'theme' => 'required|string|max:50',
                'img_url' => 'url|string|max:1000',
            ]);
        }
        return $data->validate([
        'name' => 'sometimes|max:100|string',
        'released' => 'integer|min:1970|max:2024',
        'pieces' => 'sometimes|integer|min:0',
        'rating' => 'sometimes|integer|min:0|max:10',
        'description' => 'max:500|string',
        'owned' => 'sometimes|boolean',
        'theme' => 'sometimes|string|max:50',
        'img_url' => 'url|string|max:1000',
    ]);
    }
    private function mapFields(Request $request, Set $set)
    {
        if ($request->has('name')){
            $set->name = $request->name;
        }
        if ($request->has('released')){
            $set->released = $request->released;
        }
        if ($request->has('pieces')){
            $set->pieces = $request->pieces;
        }
        if ($request->has('rating')){
            $set->rating = $request->rating;
        }
        if ($request->has('description')){
            $set->description = $request->description;
        }
        if ($request->has('owned')){
            $set->owned = $request->owned;
        }
        if ($request->has('theme')){
            $set->theme = $request->theme;
        }
        if ($request->has('img_url')){
            $set->img_url = $request->img_url;
        }
        return $set;
    }
    public function all(Request $request)
    {
        $hidden = ['description', 'pieces', 'owned'];
        $search = $request->search;

        if ($request->sort) {
            $sorting = $request->sort;
            $col = 'name';
        } else {
            $col = 'id';
            $sorting = 'asc';
        }

        if ($search) {
            return response()->json([
                'message' => 'Sets returned',
                'data' => Set::where('name', 'LIKE', "%$search%")->orderBy($col, $sorting)->get()->makeHidden($hidden),
            ]);
        }

        return response()->json([
            'message' => 'Products returned',
            'data' => Set::orderBy($col, $sorting)->get()->makeHidden($hidden),
        ]);
    }

    public function find(int $id)
    {
        return response()->json([
            'message' => 'Product returned',
            'data' => Set::find($id),
        ]);
    }

    public function create(Request $request)
    {
        $this->validInput($request);
        $set = new Set();
        $this->mapFields($request, $set);
        if (! $set->save()) {
            return response()->json([
                'message' => 'Could not create set',
            ], 500);
        }

        return response()->json([
            'message' => 'Set created',
        ], 201);
    }

    public function update(int $id, Request $request)
    {
        $this->validInput($request);
        $set = Set::find($id);
        $this->mapFields($request, $set);

        if (! $set->save()) {
            return response()->json([
                'message' => 'Could not update set',
            ], 500);
        }

        return response()->json([
            'message' => 'Set updated',
        ]);
    }

    public function delete(int $id)
    {
        $set = Set::find($id);
        if (! $set) {
            return response()->json([
                'message' => 'Error invalid set id',
            ]);
        }
        $set->delete();

        return response()->json([
            'message' => 'Set deleted',
        ]);
    }
}
