<?php

namespace App\Http\Controllers;

use App\ResourceAttribute;
use Illuminate\Http\Request;

class ResourceAttributeOptionsSortController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ResourceAttribute $attribute)
    {
        $request->validate([
            'options' => 'required | array',
            'optionBlocks' => 'array',
            'optionBlocks.*' => 'string'
        ]);

        $currentOptions = collect($attribute->options);

        $optionBlocks = $request->optionBlocks;
        $options = collect($request->options);

        $newOptions = collect();
        
        foreach ($request->options as $key => $option) {
            if (is_array($option)) {
                $block = [
                    '_name' => $optionBlocks[$key],
                    '_items' => []
                ];

                foreach ($option as $item) {
                    if ($item == 'BLOCK-EMPTY-VALUE') {
                        continue;
                    }

                    $block['_items'][] = $item;
                }

                $newOptions->push($block);
            } else {
                $newOptions->push($option);
            }
        }

        $attribute->update([
            'options' => $newOptions
        ]);

        $resourceType = $attribute->resourceType;

        return redirect()->route('resource-type.attributes.edit', [$resourceType, $attribute])
            ->with('status', "The order of options has been changed!");    
    }
}
