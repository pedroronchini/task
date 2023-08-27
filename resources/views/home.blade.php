@extends('layouts.app')

@section('content')
<div class="container">
    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Successfully saved!</strong>
        <button type="button" class="close btn-close" onclick="closeAlert('alert-success')" aria-label="Close">
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
                        <button type="button" class="btn btn-primary" onclick="$('#createTaskModal').modal('show')" data-toggle="modal" data-target="#createTaskModal">
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
        <button type="button" class="close" onclick="closeModal('createTaskModal')" data-dismiss="modal" aria-label="Close">
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
        <button type="button" class="btn btn-secondary" onclick="closeModal('createTaskModal')" data-dismiss="modal">Close</button>
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
        <button type="button" class="btn btn-secondary" onclick="closeModal('editTaskModal')" data-dismiss="modal">Close</button>
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
        <button type="button" class="btn btn-secondary" onclick="closeModal('deleteTaskModal')" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>

    $(document).ready(() => {
        listTasks();
    });

    function listTasks() {
      fetch('/api/tasks', {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
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

            $('#list-tasks').html(html_table);
        })
        .catch(error => {
            console.log(error);
        });
    }

    function createTask() {        
        const title = $('#create-title-task').val();
        const description = $('#create-description-task').val();
        const status = $('#create-status-task').val();
        const completed = status == '1' ? true : false;
        const files = $('#create-files-task');
        const date_completed = $('#create-date-completed-task').val();
        const id_user = $('#id_user').val();
        const files_array = [];
        
        if (files[0].length > 0) {
          files[0].files[0].forEach(file => {
              files_array.push(file.name);
          });
        }

        if (title != '' ) {
          fetch('/api/tasks', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json'
              },
              body: JSON.stringify({
                  'title': title,
                  'description': description,
                  'completed': completed,
                  'attached_files': files_array,
                  'completed_at': date_completed,
                  'user_id': id_user
              })
          })
          .then(response => {
              if (response.ok) {
                $('#createTaskModal').modal('hide');
                $('#alert-success').show();
                listTasks();
              } else {
                response.json().then(data => {
                  console.log('Erro:', data);
                  $('#alert-error').show();
                }).catch(error => {
                    console.error('Erro ao processar resposta:', error);
                    $('#alert-error').show();
                });
                $('#createTaskModal').modal('hide');
              }
          });
        } else {
          $('#createTaskModal').modal('hide');
          $('#alert-error').show();
        } 
    };

    function editTask(id) {
      $('#editTaskModal').modal('show');

        fetch(`/api/tasks/${id}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            let html_files = '';
            const {
                title,
                description,
                completed,
                attached_files,
                completed_at
            } = data;

            const files = attached_files.map(file => {
                html_files +=  `<span>${file.name}</span>`;

                return html_files;
            });

            const status = completed ? '1' : '0';

            $('#title-task').val(title);
            $('#description-task').val(description);
            $('#status-task').val(status);
            $('#list-files').val(files);
            $('#date-completed-task').val(completed_at);
            $('#save-task').attr('onclick', `updateTask(${id})`);
        }).catch(error => {
          $('#editTaskModal').modal('hide');
          $('#alert-error').show();
        });
    };
    
    function updateTask(id) {
        fetch(`/api/tasks/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'

            },
            body: JSON.stringify({
                title: $('#title-task').val(),
                description: $('#description-task').val(),
                completed: $('#status-task').val(),
                completed_at: $('#date-completed-task').val(),
                attached_files: [],
                user_id: $('#id_user').val(),
            }),
        })
        .then(response => {
            if (response.ok) {
              $('#editTaskModal').modal('hide');
              $('#alert-success').show();
              listTasks();
            } else {
              response.json().then(data => {
                  console.log('Erro:', data);
                  $('#alert-error').show();
              }).catch(error => {
                  console.error('Erro ao processar resposta:', error);
                  $('#alert-error').show();
              });
              $('#editTaskModal').modal('hide');
            }
        })
    };

    function deleteTask(id) {
        $('#deleteTaskModal').modal('show');

        const delete_task = document.getElementById('delete-task');

        delete_task.addEventListener('click', () => {
            $('#deleteTaskModal').modal('hide');
            fetch(`/api/tasks/${id}`, {
              method: 'DELETE',
            }).then(response => {
                if (response.ok) {
                    $('#alert-success-delete').show();
                    listTasks();
                } else {
                  response.json().then(data => {
                      console.log('Erro:', data);
                      $('#alert-error').show();
                  }).catch(error => {
                      console.error('Erro ao processar resposta:', error);
                      $('#alert-error').show();
                  });
                  $('#alert-error-delete').show();
                }
            });
        });
    };

    function closeModal(idModal) {
       $('#' + idModal).modal('hide');
    };

    function closeAlert(idAlert) {
        $('#' + idAlert).hide()
    };

</script>

@endsection
