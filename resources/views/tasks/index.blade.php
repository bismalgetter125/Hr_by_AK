@extends('master')
@section('css')
<style>
    /* Sirf tasks pages par sidebar ko icons-only banane ke liye */
    #sidebar {
        width: 70px;
        transition: width 0.3s ease;
        overflow: hidden;
    }

    #main,
    #footer {
        margin-left: 0px;
    }

    #sidebar .sidebar-nav .nav-link span {
        display: none;
        white-space: nowrap;
    }

    #sidebar .nav-content a span {
        display: none;
    }

    #sidebar:hover {
        width: 300px;
    }

    .sidebar:hover~#main,
    .sidebar:hover~#footer {
        margin-left: 300px;
    }

    #sidebar:hover .sidebar-nav .nav-link span,
    #sidebar:hover .nav-content a span {
        display: inline;
    }

    #sidebar .bi-chevron-down.ms-auto {
        display: none;
    }

    #sidebar:hover .bi-chevron-down.ms-auto {
        display: inline-block;
    }
</style>
@endsection
@section('content')
<style>
    .kanban-column {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        height: 100%;
    }

    .kanban-list {
        min-height: 500px;
        background-color: #e9ecef;
        border-radius: 5px;
        padding: 10px;
    }

    .kanban-item {
        cursor: move;
    }

    .kanban-item.invisible {
        opacity: 0.4;
    }
</style>
<main id="main" class="main">
    <div class="container">
        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded">
            <h3 class="text-center">{{ $project->name }} - Tasks</h3>
        </div>


        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">

            {{-- TO DO --}}
            <div class="col-md-3">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-primary px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">To Do</h4>
                        @hasanyrole('admin|hr_manager')
                        <button type="button"
                            class="btn btn-light"
                            data-bs-toggle="modal"
                            data-bs-target="#createTaskModal"
                            data-status="to_do"
                            style="padding: 6px 12px;">
                            +
                        </button>
                        @endhasanyrole
                    </div>

                    <div class="kanban-list" id="to_do">
                        @foreach ($tasks['to_do'] ?? [] as $task)
                        <div class="card mb-3 kanban-item"
                            data-id="{{ $task->id }}"
                            data-user="{{ $task->user_id }}"
                            data-department="{{ strtolower($task->user->employee->department) }}"
                            draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                            <div class="card-body">

                                <h5 class="card-title">{{ $task->title }}
                                    <span style="font-size: 12px; "
                                        class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </h5>


                                <p class="mb-2 text-muted">
                                    <strong>Assigned To :</strong> {{ $task->user->name }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Description :</strong> {{ $task->description }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Department :</strong> {{ $task->user->employee->department }}
                                </p>

                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button
                                    class="btn btn-dark btn-sm commentBtn"
                                    data-id="{{ $task->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#commentsModal">
                                    <i class="bi bi-chat-dots"></i>
                                </button>
<button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i>
        </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- IN PROGRESS --}}
            <div class="col-md-3">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-warning px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">In Progress</h4>
                    </div>

                    <div class="kanban-list" id="in_progress">
                        @foreach ($tasks['in_progress'] ?? [] as $task)
                        <div class="card mb-3 kanban-item"
                            data-id="{{ $task->id }}"
                            data-user="{{ $task->user_id }}"
                            data-department="{{ strtolower($task->user->employee->department) }}"
                            draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                            <div class="card-body">

                                <h5 class="card-title">{{ $task->title }}
                                    <span style="font-size: 12px; "
                                        class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </h5>

                                <p class="mb-2 text-muted">
                                    <strong>Assigned To :</strong> {{ $task->user->name }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Description :</strong> {{ $task->description }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Department :</strong> {{ $task->user->employee->department }}
                                </p>

                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button
                                    class="btn btn-dark btn-sm commentBtn"
                                    data-id="{{ $task->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#commentsModal">
                                    <i class="bi bi-chat-dots"></i>
                                </button>
                                <button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i>
        </button>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- COMPLETED --}}
            <div class="col-md-3">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-success px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">Completed</h4>
                    </div>

                    <div class="kanban-list" id="completed">
                        @foreach ($tasks['completed'] ?? [] as $task)
                        <div class="card mb-3 kanban-item"
                            data-id="{{ $task->id }}"
                            data-user="{{ $task->user_id }}"
                            data-department="{{ strtolower($task->user->employee->department) }}"
                            draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                            <div class="card-body">

                                <h5 class="card-title">{{ $task->title }}
                                    <span style="font-size: 12px; "
                                        class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </h5>

                                <p class="mb-2 text-muted">
                                    <strong>Assigned To :</strong> {{ $task->user->name }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Description :</strong> {{ $task->description }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Department :</strong> {{ $task->user->employee->department }}
                                </p>

                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button
                                    class="btn btn-dark btn-sm commentBtn"
                                    data-id="{{ $task->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#commentsModal">
                                    <i class="bi bi-chat-dots"></i>
                                </button>
<button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i>
        </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- QA --}}
            <div class="col-md-3">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-info px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">QA</h4>
                    </div>

                    <div class="kanban-list" id="qa">
                        @foreach ($tasks['qa'] ?? [] as $task)
                        <div class="card mb-3 kanban-item"
                            data-id="{{ $task->id }}"
                            data-user="{{ $task->user_id }}"
                            data-department="{{ strtolower($task->user->employee->department) }}"
                            draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                            <div class="card-body">

                                <h5 class="card-title">{{ $task->title }}
                                    <span style="font-size: 12px; "
                                        class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </h5>

                                <p class="mb-2 text-muted">
                                    <strong>Assigned To :</strong> {{ $task->user->name }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Description :</strong> {{ $task->description }}
                                </p>

                                <p class="mb-2 text-muted">
                                    <strong>Department :</strong> {{ $task->user->employee->department }}
                                </p>

                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button
                                    class="btn btn-dark btn-sm commentBtn"
                                    data-id="{{ $task->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#commentsModal">
                                    <i class="bi bi-chat-dots"></i>
                                </button>
<button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i>
        </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

{{-- QA Passed --}}
<div class="col-md-3">
    <div class="kanban-column">
        <div class="d-flex justify-content-between shadow-sm align-items-center bg-success px-3 py-2 rounded-top">
            <h4 class="text-white fw-bolder m-0">QA Passed</h4>
        </div>
<button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i>
        </button>
        <div class="kanban-list" id="qa_passed">
            @foreach ($tasks['qa_passed'] ?? [] as $task)
            <div class="card mb-3 kanban-item" data-id="{{ $task->id }}" data-user="{{ $task->user_id }}"
                data-department="{{ strtolower($task->user->employee->department) }}" draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}
                        <span class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- QA Failed --}}
<div class="col-md-3">
    <div class="kanban-column">
        <div class="d-flex justify-content-between shadow-sm align-items-center bg-danger px-3 py-2 rounded-top">
            <h4 class="text-white fw-bolder m-0">QA Failed</h4>
        </div>
<button
            class="btn btn-secondary btn-sm trackHistoryBtn"
            data-id="{{ $task->id }}"
            data-bs-toggle="modal"
            data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i> 
        </button>
        <div class="kanban-list" id="qa_failed">
            @foreach ($tasks['qa_failed'] ?? [] as $task)
            <div class="card mb-3 kanban-item" data-id="{{ $task->id }}" data-user="{{ $task->user_id }}"
                data-department="{{ strtolower($task->user->employee->department) }}" draggable="{{ auth()->id() == $task->user_id ? 'true' : 'false' }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}
                        <span class="badge text-white {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

        </div>

        {{-- CREATE TASK MODAL --}}
        <div class="modal fade" id="createTaskModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Create Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Assign To</label>
                                <select name="user_id" class="form-select">
                                    <option value="{{ auth()->user()->id }}">Self</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="status" id="task_status">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Task</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- COMMENTS MODAL --}}
        <div class="modal fade" id="commentsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Task Comments</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="commentsBody">
                        {{-- Comments will load here dynamically via JS --}}
                    </div>

                    <div class="modal-footer">
                        <input type="text" id="newComment" class="form-control" placeholder="Write a comment...">
                        <button type="button" id="sendComment" class="btn btn-primary">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </section>

    </div>
</main>
{{-- HISTORY MODAL --}}
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Task History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="historyBody">
                {{-- History will load dynamically via JS --}}
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {

    const historyButtons = document.querySelectorAll('.trackHistoryBtn');
    const historyBody = document.getElementById('historyBody');

    historyButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const taskId = btn.getAttribute('data-id');
            loadHistory(taskId);
        });
    });

    function loadHistory(taskId) {
        historyBody.innerHTML = 'Loading...';

        fetch(`/tasks/${taskId}/history`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    historyBody.innerHTML = '<p>No history yet.</p>';
                    return;
                }

                let html = `<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Previous Status</th>
                            <th>New Status</th>
                            <th>Assigned To</th>
                            <th>Changed By</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>`;

                data.forEach((item, index) => {
                    html += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.old_status}</td>
                        <td>${item.new_status}</td>
                        <td>${item.assigned_to}</td>
                        <td>${item.changed_by}</td>
                        <td>${item.created_at}</td>
                    </tr>`;
                });

                html += `</tbody></table>`;
                historyBody.innerHTML = html;
            })
            .catch(err => {
                historyBody.innerHTML = '<p class="text-danger">Failed to load history.</p>';
                console.error(err);
            });
    }

});
    document.addEventListener('DOMContentLoaded', (event) => {


        const kanbanItems = document.querySelectorAll('.kanban-item');
        const kanbanLists = document.querySelectorAll('.kanban-list');
        const createTaskModal = document.getElementById('createTaskModal');
        const taskStatusInput = document.getElementById('task_status');

        if (createTaskModal) {
            createTaskModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const status = button.getAttribute('data-status');
                taskStatusInput.value = status;
            });
        }

        kanbanItems.forEach(item => {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragend', handleDragEnd);
        });

        kanbanLists.forEach(list => {
            list.addEventListener('dragover', handleDragOver);
            list.addEventListener('drop', handleDrop);
        });

        function handleDragStart(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
            setTimeout(() => {
                e.target.classList.add('invisible');
            }, 0);
        }

        function handleDragEnd(e) {
            e.target.classList.remove('invisible');
        }

        function handleDragOver(e) {
            e.preventDefault();
        }

 function handleDrop(e) {
    e.preventDefault();

    const id = e.dataTransfer.getData('text');
    const draggableElement = document.querySelector(`.kanban-item[data-id='${id}']`);
    const dropzone = e.target.closest('.kanban-list');
    if (!dropzone) return;

    const newStatus = dropzone.id;
    const assignedUserId = draggableElement.getAttribute('data-user');
    const department = draggableElement.getAttribute('data-department').toLowerCase();
    const currentUserId = "{{ auth()->id() }}";
    const currentColumn = draggableElement.parentElement.id;

    // ----------------------------
    // Define allowed moves visually
    // ----------------------------
    const allowedMoves = {
        to_do: ['in_progress'],
        in_progress: ['to_do', 'completed', 'qa'], // user can move to QA
        completed: ['in_progress', 'qa'],          // user can move to QA
        qa: [],                                    // only SQA can move further
        qa_passed: [],
        qa_failed: ['in_progress'],                // SQA can move back to in_progress if needed
    };

    // SQA overrides
    if (department === 'sqa') {
        allowedMoves['qa'] = ['qa_passed', 'qa_failed'];
        allowedMoves['qa_failed'] = ['in_progress'];
    }

    // ----------------------------
    // Permission check
    // ----------------------------
    const isAssignedUser = assignedUserId == currentUserId;
    const isSQA = department === 'sqa';

    // Normal users can move their own tasks
    if (!isAssignedUser && !isSQA) {
        alert("Only assigned user or SQA can move this task.");
        return;
    }

    // Only SQA can move tasks out of QA
    if (currentColumn === 'qa' && !isSQA) {
        alert("Only SQA can move tasks from QA.");
        return;
    }

    // Check if the move is allowed
    if (!allowedMoves[currentColumn] || !allowedMoves[currentColumn].includes(newStatus)) {
        alert("You are not allowed to move this task here.");
        return;
    }

    // Move the card visually
    draggableElement.parentNode.removeChild(draggableElement);
    dropzone.appendChild(draggableElement);

    // Update status in DB
    updateTaskStatus(id, newStatus);
}

        function updateTaskStatus(id, status) {
            fetch(`/tasks/${id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to update task status');
                    return response.json();
                })
                .then(data => console.log('Task status updated:', data))
                .catch(error => console.error('Error:', error));
        }

        // -----------------------------
        // COMMENTS MODAL FUNCTIONALITY
        // -----------------------------
        const commentButtons = document.querySelectorAll('.commentBtn');
        const commentsBody = document.getElementById('commentsBody');
        const sendCommentBtn = document.getElementById('sendComment');
        const newCommentInput = document.getElementById('newComment');
        let currentTaskId = null;

        // Only attach if elements exist
        if (commentButtons.length && commentsBody && sendCommentBtn && newCommentInput) {

            commentButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentTaskId = btn.getAttribute('data-id');
                    loadComments(currentTaskId);
                });
            });

            sendCommentBtn.addEventListener('click', () => {
                const commentText = newCommentInput.value.trim();
                if (!commentText || !currentTaskId) return;

                fetch(`/tasks/${currentTaskId}/comments`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            comment: commentText
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        newCommentInput.value = '';
                        loadComments(currentTaskId); // reload comments
                    })
                    .catch(err => console.error(err));
            });

            function loadComments(taskId) {
                commentsBody.innerHTML = 'Loading...';

                fetch(`/tasks/${taskId}/comments`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            commentsBody.innerHTML = '<p>No comments yet.</p>';
                            return;
                        }

                        commentsBody.innerHTML = '';
                        data.forEach(comment => {
                            const commentDiv = document.createElement('div');
                            commentDiv.classList.add('mb-2', 'p-2', 'border', 'rounded');
                            commentDiv.innerHTML = `<strong>${comment.user_name}</strong>: ${comment.comment}`;
                            commentsBody.appendChild(commentDiv);
                        });
                    })
                    .catch(err => {
                        commentsBody.innerHTML = '<p class="text-danger">Failed to load comments.</p>';
                        console.error(err);
                    });
            }
        }

    });
</script>
</main>
@endsection
