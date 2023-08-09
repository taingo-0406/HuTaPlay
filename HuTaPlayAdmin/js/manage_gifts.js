$(document).ready(function () {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    function getGifts() {
        $.ajax({
            url: '../database/admin/check_all_gifts.php',
            type: 'GET',
            dataType: 'json',
            success: function (gifts) {
                gifts = gifts.map(gift => ({
                    ...gift,
                    display: Number(gift.display)
                }));
                // initialize the DataTables plugin on the table
                var table = $('.table').DataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [
                        {
                            text: 'Add new gift',
                            action: function () {
                                $('#addEmployeeModal').modal('show');
                            }
                        }
                    ],
                    data: gifts,
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'cost' },
                        {
                            data: 'display',
                            render: function (data, type, row) {
                                return data ? 'Yes' : 'No';
                            }
                        },
                        {
                            data: null,
                            defaultContent:
                                '<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit"></i></a>',
                            orderable: false
                        }
                    ]
                });
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
    }

    function getGiftsAfterEditing() {
        table = $('.table').DataTable();
        $.ajax({
            url: '../database/admin/check_all_gifts.php',
            type: 'GET',
            dataType: 'json',
            success: function (gifts) {
                // clear the existing data from the table
                table.clear();
                // add the new data to the table
                table.rows.add(gifts);
                // redraw the table
                table.draw();
            }
        });
    }

    $('#edit-gift').on('submit', function (event) {
        event.preventDefault();
        const id = $('#edit-gift input[name="id"]').val();
        const name = $('#edit-gift input[name="name"]').val();
        const cost = $('#edit-gift input[name="cost"]').val();
        const display = $('#edit-gift select[name="display"]').val();
        $('#editEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/edit_gift.php',
            type: 'POST',
            data: { id: id, name: name, cost: cost, display: display },
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Gift edited.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getGiftsAfterEditing();
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

    $('#add-gift').on('submit', function (event) {
        event.preventDefault();
        const name = $('#add-gift input[name="name"]').val();
        const cost = $('#add-gift input[name="cost"]').val();
        const display = $('#add-gift select[name="display"]').val();
        $('#addEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/add_gift.php',
            type: 'POST',
            dataType: 'json',
            data: { name: name, cost: cost, display: display },
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Gift added.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getGiftsAfterEditing();
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something wrong while adding.',
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
        // fill the modal's input fields with the data
        $('#editEmployeeModal .modal-body input:eq(0)').val(id);
        $('#editEmployeeModal .modal-body input:eq(1)').val(name);
        $('#editEmployeeModal .modal-body input:eq(2)').val(email);
        $('#editEmployeeModal .modal-body input:eq(3)').val(points);
    });

    getGifts();
});