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
        // initialize the DataTables plugin on the table
        $('.table').DataTable({
          data: users,
          columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'points' },
            { data: 'stage' },
            {
              data: null,
              defaultContent:
                '<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit"></i></a>',
              orderable: false
            }
          ]
        });
      }
    });
  }

  function getUsersAfterEditing() {
    table = $('.table').DataTable();
    $.ajax({
      url: '../database/admin/check_all_users.php',
      type: 'GET',
      dataType: 'json',
      success: function (users) {
        // clear the existing data from the table
        table.clear();
        // add the new data to the table
        table.rows.add(users);
        // redraw the table
        table.draw();
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
        getUsersAfterEditing();
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
    // get the modal's ID
    const modalId = $('#myModal').attr('id');

    // check if the modal's ID is odd or even
    if (modalId % 2 == 1) {
      // if the modal's ID is odd, disable the input with the name "toh-discs"
      $('input[name="toh-discs"]').prop('disabled', true);
    } else {
      // if the modal's ID is even, disable the input with the name "memory_size"
      $('input[name="memory_size"]').prop('disabled', true);
    }

    // get the current table row
    tr = $(this).closest('tr');
    // get the data from the table cells
    const name = tr.find('td:eq(1)').text();
    const email = tr.find('td:eq(2)').text();
    const points = tr.find('td:eq(3)').text();
    const stage = tr.find('td:eq(4)').text();
    // fill the modal's input fields with the data
    $('#editEmployeeModal .modal-body input:eq(0)').val(name);
    $('#editEmployeeModal .modal-body input:eq(1)').val(email);
    $('#editEmployeeModal .modal-body input:eq(2)').val(points);
    $('#editEmployeeModal .modal-body input:eq(3)').val(stage);
  });

  getUsers();
});


