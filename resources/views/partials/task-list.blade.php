        <td><a href="tasks/{{ $task->task_id }}">{{ $task->name }}</a></td>
        <td>{{ $task->due_date }}</td>
        <td class="task-status">{{ $task->status}}</td>
        <td>{{ $task->priority}}</td>
        <td>{{ $task->project->name}}</td>
</tr>