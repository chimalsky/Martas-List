
<table class="w-full text-left">
    <tr>
        <th class="pr-4">
            Resource Attribute Key/Name 
        </th>
        <th>
            Resource
        </th>
        <th class="">
            Type of Action
        </th>
        <th>
            New Value
        </th>
        <th class="pl-4 text-right">
            By
        </th>
    </tr>
<thead>
</thead>

<tbody>
@foreach ($activities as $activity)    
    <tr class="">
        <td class="pr-4 pb-3">
            {{ $activity->subject->resourceAttribute->name ?? '' }}
        </td>

        <td>
            of 
            <a href="{{ route('resources.edit', $activity->subject->resource) }}"
                class="underline">
                {{ $activity->subject->resource->name }} 
            </a>
        </td>

        <td>
            {{ $activity->description }}
        </td>
        <td>
            {{ $activity->properties['attributes']['value'] }}
        </td>

        <td class="pl-4 text-right">
            {{ $activity->causer->name ?? 'unknown stranger on the internet' }} -- {{ $activity->created_at }}
        </td>
    </tr> 
@endforeach
</tbody>