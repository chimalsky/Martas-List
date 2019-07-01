@foreach ($resources as $resource)
    <label class="p-4">
        <input name="resources[]" value="{{ $resource->id }}" type="checkbox" class="form-checkbox" />
        {{ $resource->name }}
    </label>
@endforeach