<section class="ticket">
        <a class="task-name" href="/tasks/{{ $task->task_id }}" > {{ $task->name }}</a>
        <p class="ticket-department"> {{ $task-> due_date}} </p>
        <p class="task-member">{{ $task->assignedMember->name }}</p>
        <div class="ticket-container">
          <div class="ticket-priority">
              @if ($task->priority === 'High')
                  <span class="high">{{ $task->priority }}</span>
              @elseif ($task->priority === 'Medium') 
                 <span class="medium"> {{$task->priority}}</span>
              @elseif ($task->priority === 'Low') 
                  <span class="low">{{ $task->priority }}</span>
              @endif
          </div>
        </div>
</section>