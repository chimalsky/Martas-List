<?php

namespace App\Http\Controllers;

use Excel;
use App\ResourceType;
use Illuminate\Http\Request;
use App\Imports\ResourcesImport;

class ResourceSpreadsheetImportController extends Controller
{
    public function show(Request $request, ResourceType $resourceType)
    {
        return view('resource-type.import.spreadsheet.show', compact('resourceType'));
    }

    public function store(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'spreadsheet' => 'required | file'
        ]);

        $resourcesImport = new ResourcesImport;
        $resourcesImport->resourceType = $resourceType;

        Excel::import($resourcesImport, $request->spreadsheet);

        return back()->with('status', 'wowwww');
    }
}
