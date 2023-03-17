@if ($poem->circulation && $poem->circulation->value == 'unknown')
    <span class="italic">Circulation status unknown.</span>
@else
    @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a letter draft (uncirculated)')
        <span class="italic">Retained in Dickinson's archive.</span>
    @else
        @if ($poem->formOfSentPoem)
            @if (strtolower($poem->formOfSentPoem->value) == 'poem-message')
                <span class="italic">Poem-message</span>
            @endif
            @if (strtolower($poem->formOfSentPoem->value) == 'poem')
                <span class="italic">Poem</span>
            @endif
            @if (strtolower($poem->formOfSentPoem->value) == 'poem embedded in a message')
                <span class="italic">Poem embedded in a message</span>
            @endif
            @if (strtolower($poem->formOfSentPoem->value) == 'poem enclosed in a message')
                <span class="italic">Poem enclosed in a message</span>
            @endif
        @endif

        Sent to ({{ $poem->circulation->value }}).
    @endif
@endif