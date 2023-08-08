$(document).ready(function () {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    // define the function to get all stages' information
    function getStages() {
        // send an AJAX request to the get_stages.php script
        $.ajax({
            url: '../database/admin/check_all_stages.php',
            type: 'GET',
            dataType: 'json',
            success: function (stages) {
                // initialize the DataTables plugin on the table
                $('.table').DataTable({
                    data: stages,
                    columns: [
                        { data: 'id' },
                        { data: 'toh_disk' },
                        { data: 'memory_size' },
                        { data: 'optimal_point' },
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

    function getStagesAfterEditing() {
        table = $('.table').DataTable();
        $.ajax({
            url: '../database/admin/check_all_stages.php',
            type: 'GET',
            dataType: 'json',
            success: function (stages) {
                // clear the existing data from the table
                table.clear();
                // add the new data to the table
                table.rows.add(stages);
                // redraw the table
                table.draw();
            }
        });
    }

    // add an event listener to the form
    $('#edit-stage').on('submit', function (event) {
        // prevent the default form submission
        event.preventDefault();
        const id = $('#edit-stage input[name="id"]').val();
        const toh_discs = $('#edit-stage input[name="toh-discs"]').val();
        const memory_size = $('#edit-stage input[name="memory-size"]').val();
        const optimal_points = $('#edit-stage input[name="optimal-points"]').val();
        $('#editEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/edit_stage.php',
            type: 'POST',
            data: { id: id, toh_discs: toh_discs, memory_size: memory_size, optimal_points: optimal_points },
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'stage edited.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getStagesAfterEditing();
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
        tr = $(this).closest('tr');
        // get the data from the table cells
        const id = tr.find('td:eq(0)').text();
        const name = tr.find('td:eq(1)').text();
        const email = tr.find('td:eq(2)').text();
        const points = tr.find('td:eq(3)').text();

        if (id % 2 == 0) {
            // if the modal's ID is odd, disable the input with the name "toh-discs"
            $('input[name="toh-discs"]').prop('disabled', true);
            $('input[name="memory-size"]').prop('disabled', false);
        } else {
            // if the modal's ID is even, disable the input with the name "memory_size"
            $('input[name="memory-size"]').prop('disabled', true);
            $('input[name="toh-discs"]').prop('disabled', false);
        }
        // fill the modal's input fields with the data
        $('#editEmployeeModal .modal-body input:eq(0)').val(id);
        $('#editEmployeeModal .modal-body input:eq(1)').val(name);
        $('#editEmployeeModal .modal-body input:eq(2)').val(email);
        $('#editEmployeeModal .modal-body input:eq(3)').val(points);
    });

    getStages();
});