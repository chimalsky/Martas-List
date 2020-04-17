@extends ('resource-type._layout')

@section ('content')

<form action="@route('resource-type.spreadsheetImport.store', $resourceType)" 
    enctype="multipart/form-data"
    method="post">
    @csrf 

    <label class="block my-8">
        Upload your spreadsheet
        
        <input type="file" name="spreadsheet" 
            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" 
            class="block mt-2" />
    </label>


    <button class="btn btn-blue">
        Import resources
    </button>

</form>

@endsection