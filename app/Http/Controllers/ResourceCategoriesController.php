<?php

namespace App\Http\Controllers;

use App\ResourceType;
use App\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourceCategoriesController extends Controller
{
    public function index(Request $request, ResourceType $resourceType)
    {
        $categories = $resourceType->categories;
        $categories->loadCount('resources');

        return view('resource-categories.index', compact('resourceType', 'categories'));
    }

    public function store(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'name' => [
                'required', 
                'max:255', 
                Rule::unique('resource_categories')->where(function ($query) use ($resourceType) {
                    return $query->where('resource_type_id', $resourceType->id);
                })
            ]
        ]);

        $category = $resourceType->categories()->create([
            'name' => $request->name
        ]);

        return back()->with('status', "{$category->name} category was created");
    }

    public function show(Request $request, ResourceCategory $category)
    {
        $resourceType = $category->resourceType;

        return view('resource-categories.show', compact('resourceType', 'category'));
    }
}
