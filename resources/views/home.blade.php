@extends('layouts.app')

@section('content')
<div class="container">
    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Successfully saved!</strong>
        <button type="button" class="close btn-close" onclick="closeAlert('alert-success')" aria-label="Close">" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="alert-error" class="alert alert-warning alert-dismissible fade show" role="alert"  style="display: none;">
        <strong>Could not save, please try again!</strong>
        <button type="button" class="close btn-close" onclick="closeAlert('alert-error')" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="alert-success-delete" class="alert alert-success alert-dismissible fade show" role="alert"  style="display: none;">
        <strong>Successfully task deleted!</strong>
        <button type="button" class="close btn-close" onclick="closeAlert('alert-success-delete')"  data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="alert-error-delete" class="alert alert-warning alert-dismissible fade show" role="alert"  style="display: none;">
        <strong>Could not delete, please try again!</strong>
        <button type="button" class="close btn-close" onclick="closeAlert('alert-error-delete')"  data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">Dashboard
                    <div class="float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">
                            Create Task
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
            <div id="list-tasks"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTaskModalLabel">Edit Task</h5>
        <button type="button" class="close" onclick="closeModal('createTaskModalLabel')" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="create-title-task" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="create-title-task">
          </div>
          <div class="form-group">
            <label for="create-description-task" class="col-form-label">Description:</label>
            <textarea class="form-control" id="create-description-task"></textarea>
          </div>
          <div class="form-group">
            <label for="create-status-task" class="col-form-label">Status:</label>
            <select class="form-control" id="create-status-task">
                <option value="0">Pending</option>
                <option value="1">Completed</option>
            </select>
          </div>
          <div class="form-group">
            <label for="create-files-task" class="col-form-label">Files:</label>
            ><input type="file" name="create-files-task" id="create-files-task" multiple>
          </div>
          <div class="form-group">
            <label for="create-date-completed-task" class="col-form-label">Completed Date:</label>
            <input type="date" class="form-control" id="create-date-completed-task">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createTask()">Create</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
        <button type="button" class="close" onclick="closeModal('editTaskModal')" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="title-task" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="title-task">
          </div>
          <div class="form-group">
            <label for="description-task" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description-task"></textarea>
          </div>
          <div class="form-group">
            <label for="status-task" class="col-form-label">Status:</label>
            <select class="form-control" id="status-task">
                <option value="0">Pending</option>
                <option value="1">Completed</option>
            </select>
          </div>
          <div class="form-group">
            <label for="files-task" class="col-form-label">Files:</label>
            <div id="list-files"></div>
          </div>
          <div class="form-group">
            <label for="date-completed-task" class="col-form-label">Completed Date:</label>
            <input type="date" class="form-control" id="date-completed-task">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-task">Save</button>
      </div>
    </div>
  </div>
</div>

<div id="deleteTaskModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Task</h5>
        <button type="button" class="close" onclick="closeModal('deleteTaskModal')" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this task?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="delete-task">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        fetch('/api/tasks', {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            let div_table = document.getElementById('list-tasks');
            let html_table = '';

            html_table += `<table class="table table-striped">`;
            html_table += `<thead>`;
            html_table += `<tr>`;
            html_table += `<th scope="col">Id</th>`;
            html_table += `<th scope="col">Title</th>`;
            html_table += `<th scope="col">Description</th>`;
            html_table += `<th scope="col">Status</th>`;
            html_table += `<th scope="col">Date Completed</th>`;
            html_table += `<th scope="col">User</th>`;
            html_table += `<th scope="col">Action</th>`;
            html_table += `</tr>`;
            html_table += `</thead>`;
            html_table += `<tbody>`;

            if (data.length > 0) {
                data.forEach(task => {
                    const {
                        id,
                        title,
                        description,
                        completed,
                        completed_at,
                        user_id
                    } = task;

                    const status = completed ? 'Completed' : 'Pending';
                    const date_completed = completed ? completed_at : '';

                    html_table += `<tr>`;
                    html_table += `<th scope="row">${id}</th>`;
                    html_table += `<td>${title}</td>`;
                    html_table += `<td>${description}</td>`;
                    html_table += `<td>${status}</td>`;
                    html_table += `<td>${date_completed}</td>`;
                    html_table += `<td>${user_id}</td>`;
                    html_table += `<td>`;
                    html_table += `<button type="button" class="btn btn-primary" style="margin-right: 5px" onclick="editTask(${id})">Edit</button>`;
                    html_table += `<button type="button" class="btn btn-danger" onclick="deleteTask(${id})">Delete</button>`;
                    html_table += `</td>`;
                });

            } else {
                html_table += `<tr>`;
                html_table += `<td colspan="6">No tasks</td>`;
                html_table += `</tr>`;
            }

            html_table += `</tbody>`;
            html_table += `</table>`;

            div_table.innerHTML = html_table;
        })
        .catch(error => {
            console.log(error);
        });


    });

    function createTask() {
        const modal = document.getElementById('createTaskModal');
        const alert_success = document.getElementById('alert-success');
        const alert_error = document.getElementById('alert-error');
        
        const title = document.getElementById('create-title-task').value;
        const description = document.getElementById('create-description-task').value;
        const status = document.getElementById('create-status-task').value;
        const files = document.getElementById('create-files-task');
        const date_completed = document.getElementById('create-date-completed-task').value;
        const id_user = document.getElementById('id_user').value;
        
        const files_array = [];
        files.files.forEach(file => {
            files_array.push(file.name);
        });

        fetch('/api/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title,
                description,
                status,
                files_array,
                date_completed,
                id_user
            })
        })
        .then(response => {
            if (response.ok) {
                modal.style.display = 'none';
                alert_success.style.display = 'block';
            } else {
                modal.style.display = 'none';
                alert_error.style.display = 'block';
            }
        })
        
    };

    function editTask(id) {
        const modal = document.getElementById('editTaskModal');
        const alert = document.getElementById('alert-error');

        modal.style.display = 'block';

        fetch(`/api/tasks/${id}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            let html_files = '';
            const {
                title,
                description,
                status,
                attached_files,
                completed_at
            } = data;

            const files = attached_files.map(file => {
                html_files +=  `<span>${file.name}</span>`;

                return html_files;
            });

            const input_title = document.getElementById('title-task');
            const input_description = document.getElementById('description-task');
            const select_status = document.getElementById('status-task');
            const list_files = document.getElementById('list-files');
            const input_date_completed = document.getElementById('date-completed-task');
            const save_task = document.getElementById('save-task');

            input_title.value = title;
            input_description.value = description;
            select_status.value = status;
            list_files.innerHTML = html_files;
            input_date_completed.value = completed_at;
            save_task.addEventListener('click', () => {
                updateTask(id);
                modal.style.display = 'none';
            });
        }).catch(error => {
            modal.style.display = 'none';
            alert.style.display = 'block';
        });
    };
    
    function updateTask(id) {
        const alert_success = document.getElementById('alert-success');
        const alert_error = document.getElementById('alert-error');

        fetch(`/api/tasks/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'

            },
            body: JSON.stringify({
                title: document.getElementById('title-task').value,
                description: document.getElementById('description-task').value,
                status: document.getElementById('status-task').value,
                completed_at: document.getElementById('date-completed-task').value,
                attached_files: [],
                completed_at: document.getElementById('date-completed-task').value,
                id_user: document.getElementById('id_user').value,
            }),
        })
        .then(response => {
            if (response.ok) {
                alert_success.style.display = 'block';
            } else {
                alert_error.style.display = 'block';
            }
        })
    };

    function deleteTask(id) {
        const modal = document.getElementById('deleteTaskModal');
        const alert_success = document.getElementById('alert-success-delete');
        const alert_error = document.getElementById('alert-error-delete');
        const delete_task = document.getElementById('delete-task');

        modal.style.display = 'block';

        delete_task.addEventListener('click', () => {
            modal.style.display = 'none';
            fetch(`/api/tasks/${id}`, {}).then(response => {
                if (response.ok) {
                    alert_success.style.display = 'block';
                } else {
                    alert_error.style.display = 'block';
                }
            });
        });
    };

    function closeModal(idModal) {
        const modal = document.getElementById(idModal);

        modal.style.display = 'none';
    };

    function closeAlert(idAlert) {
        const alert = document.getElementById(idAlert);

        alert.style.display = 'none';
    };

</script>

@endsection
