<td><a href="projects/{{ $fav->proj_id }}">{{ $fav->name }}</a></td>
        <td>{{ $fav->due_date }}</td>
        <td>{{ $fav->company->name }}</td>
        <td>{{ $fav->coordinator->name }}</td>
</tr>