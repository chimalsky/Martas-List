
<table class="w-full text-left">
<thead>
    <tr>
        <th>
            Resource
        </th>
        <th class="">
            Type of Action
        </th>
        <th class="pr-4">
            Resource Attribute Key/Name 
        </th>
        <th>
            New Value
        </th>
        <th>
            By
        </th>
        <th class="pl-4 text-right">
            Date
        </th>
    </tr>
</thead>

<tbody class="">
@foreach ($activities as $activity)    
    <tr class="">
        <td>
            <a href="{{ route('resources.edit', $activity->subject->resource) }}"
                class="underline">
                {{ $activity->subject->resource->name }} 
            </a>
        </td>

        <td>
            {{ $activity->description }}
        </td>

        <td class="pr-4 pb-3">
            {{ $activity->subject->resourceAttribute->name ?? '' }}
        </td>
        
        <td>
            {{ $activity->properties['attributes']['value'] }}
        </td>

        <td>
            {{ $activity->causer->name ?? 'unknown stranger on the internet' }}
        </td>

        <td class="pl-4 text-right">
            {{ $activity->created_at }}
        </td>
    </tr> 
@endforeach
</tbody>
</table>