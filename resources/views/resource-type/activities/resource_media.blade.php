
<table class="w-full text-left">
    <tr>
        <th class="pr-4">
            Media
        </th>
        <th>
            Resource
        </th>
        <th class="">
            Type of Action
        </th>
        <th class="">
            By
        </th>
        <th class="pl-4 text-right">
            Date
        </th>
    </tr>
<thead>
</thead>

<tbody>
@foreach ($activities as $activity)    
    <tr class="">
        <td class="pr-4 pb-3 max-w-xs">
            {{ $activity->subject }}
        </td>

        <td>
            associated with
            <a href="{{ route('resources.edit', $activity->subject->model) }}"
                class="underline">
                {{ $activity->subject->model->name }} 
            </a>
        </td>

        <td>
            {{ $activity->description }}
        </td>
        <td class="pl-4">
            {{ $activity->causer->name ?? 'unknown stranger on the internet' }}
        </td>
        <td class="pt-4 text-right">
            {{ $activity->created_at }}
        </td>
    </tr> 
@endforeach
</tbody>
