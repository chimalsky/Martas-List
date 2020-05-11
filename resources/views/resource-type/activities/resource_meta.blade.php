
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
            <p class=" px-2
                @if ($activity->description == 'created') 
                    text-green-300 
                @elseif ($activity->description == 'updated')
                    text-yellow-300 
                @endif
            ">
                {{ $activity->description }}
            </p>
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
            @if (carbon($activity->created_at)->diffInDays() > 1)
                <local-time datetime="{{ $activity->created_at .' '. config('app.timezone') }}"
                    month="short"
                    day="numeric"
                    year="numeric"
                    hour="numeric"
                    minute="numeric">
                </local-time>
            @else
                <relative-time datetime="{{ $activity->created_at .' '. config('app.timezone') }}">
                </relative-time>
            @endif
        </td>
    </tr> 
@endforeach
</tbody>
</table>