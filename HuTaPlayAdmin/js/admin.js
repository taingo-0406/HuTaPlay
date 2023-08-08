$(document).ready(function () {
  // Activate tooltip
  $('[data-toggle="tooltip"]').tooltip();
  // define the function to get all users' information
  function getUsers() {
    // send an AJAX request to the get_users.php script
    $.ajax({
      url: '../database/admin/check_all_users.php',
      type: 'GET',
      dataType: 'json',
      success: function (users) {
        // get the table body element
        tbody = $('.table tbody');
        // clear the table body
        tbody.empty();
        // loop through the users array
        for (i = 0; i < users.length; i++) {
          // create a new table row
          tr = $('<tr></tr>');
          // create the table cells
          tdId = $('<td></td>').text(users[i].id);
          tdName = $('<td></td>').text(users[i].name);
          tdEmail = $('<td></td>').text(users[i].email);
          tdPoints = $('<td></td>').text(users[i].points);
          tdStage = $('<td></td>').text(users[i].stage);
          tdActions = $(
            '<td><a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit"></i></a></td>'
          );
          // append the table cells to the table row
          tr.append(tdId, tdName, tdEmail, tdPoints, tdStage, tdActions);
          // append the table row to the table body
          tbody.append(tr);
        }
      }
    });
  }

  // add an event listener to the form
  $('#edit-user').on('submit', function (event) {
    // prevent the default form submission
    event.preventDefault();
    const name = $('#edit-user input[name="name"]').val();
    const email = $('#edit-user input[name="email"]').val();
    const points = $('#edit-user input[name="points"]').val();
    const stage = $('#edit-user input[name="stage"]').val();
    // do something with the data
    console.log(name, email, points, stage);
    $('#editEmployeeModal').modal('hide');
    $.ajax({
      url: '../database/admin/edit_user.php',
      type: 'POST',
      data: { email: email, name: name, points: points, stage: stage },
      success: function () {
        Swal.fire({
          title: 'Success!',
          text: 'User edited.',
          icon: 'success',
          confirmButtonText: 'OK',
        })
      },
      error: function () {
        Swal.fire({
          title: 'Error!',
          text: 'Something wrong while edit.',
          icon: 'error',
          confirmButtonText: 'OK',
        })
      }
    });
  });

  $('.table tbody').on('click', '.edit', function () {
    // get the current table row
    tr = $(this).closest('tr');
    // get the data from the table cells
    name = tr.find('td:eq(1)').text();
    email = tr.find('td:eq(2)').text();
    points = tr.find('td:eq(3)').text();
    stage = tr.find('td:eq(4)').text();
    // fill the modal's input fields with the data
    $('#editEmployeeModal .modal-body input:eq(0)').val(name);
    $('#editEmployeeModal .modal-body input:eq(1)').val(email);
    $('#editEmployeeModal .modal-body input:eq(2)').val(points);
    $('#editEmployeeModal .modal-body input:eq(3)').val(stage);
  });

  getUsers();
});


