<td><a href="projects/{{ $project->proj_id }}">{{ $project->name }}</a></td>
        <td>{{ $project->due_date }}</td>
        <td>{{ $project->company->name }}</td>
        <td>{{ $project->coordinator->name }}</td>
</tr>
