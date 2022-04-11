<?php

namespace App\Http\Controllers;

use App\ResourceAttribute;
use Illuminate\Http\Request;

class AttributeOptionsBlockStore extends Controller
{
    public function __invoke(Request $request, ResourceAttribute $resourceAttribute)
    {
        $currentOptions = collect($resourceAttribute->options);

        $request->validate([
            'block' => ['required', 'string', 'between:1,255', function ($attribute, $value, $fail) use ($currentOptions) {
                if ($currentOptions->contains($value)) {
                    $fail($attribute.' already exists.');
                }
            }],
        ]);

        $resourceAttribute->update([
            'options' => $currentOptions->push(
               [
                   '_name' => $request->block,
                   '_items' => [],
               ]
            )->toArray(),
        ]);

        return back()->with('status', "Block {$request->block} was added");
    }
}
