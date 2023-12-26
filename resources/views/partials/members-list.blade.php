<div id="members-container">
    <td><a href="{{ route('memberProfile', ['user_id' => $member->user_id]) }}">{{ $member->name }}</a> 
    @if($member->user_id === $project->coord_id)
     - coordinator
    @endif
    </td>
    </tr>
</div>