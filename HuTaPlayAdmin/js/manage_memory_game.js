$(document).ready(function () {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    function getMemoryImages() {
        $.ajax({
            url: '../database/admin/check_all_memory_images.php',
            type: 'GET',
            dataType: 'json',
            success: function (images) {
                // initialize the DataTables plugin on the table
                var table = $('.table').DataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [
                        {
                            text: 'Add new images',
                            action: function () {
                                $('#addEmployeeModal').modal('show');
                            }
                        }
                    ],
                    data: images,
                    columns: [
                        { data: 'id' },
                        {
                            data: 'image',
                            render: function (data, type, row) {
                                return '<img class = "memory-images" src="data:image/jpeg;base64,' + data + '" />';
                            }
                        },
                        {
                            data: null,
                            defaultContent:
                                '<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit"></i></a>' +
                                '<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete"></i></a>',
                            orderable: false
                        }
                    ]
                });

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
    }

    function getMemoryImagesAfterEditing() {
        table = $('.table').DataTable();
        $.ajax({
            url: '../database/admin/check_all_memory_images.php',
            type: 'GET',
            dataType: 'json',
            success: function (images) {
                // clear the existing data from the table
                table.clear();
                // add the new data to the table
                table.rows.add(images);
                // redraw the table
                table.draw();
            }
        });
    }

    $('#edit-image').on('submit', function (event) {
        event.preventDefault();
        var id = $('#edit-image input[name="id"]').val();
        var file_data = $('#edit-image input[type="file"]').prop('files')[0];
        var form_data = new FormData();
        console.log(id);
        console.log(file_data);
        form_data.append('id', id);
        form_data.append('file', file_data);
        $('#editEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/edit_memory_image.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Image edited.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getMemoryImagesAfterEditing();
            },
            error: function () {
                console.log('error');
                Swal.fire({
                    title: 'Error!',
                    text: 'Something wrong while edit.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                })
            }
        });
    });

    $('#add-image').on('submit', function (event) {
        event.preventDefault();
        var form_data = new FormData();
        var files = $('#add-image input[type="file"]').prop('files');
        for (var i = 0; i < files.length; i++) {
            form_data.append('files[]', files[i]);
        }
        $('#addEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/add_memory_images.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Images added.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getMemoryImagesAfterEditing();
            },
            error: function () {
                console.log('error');
                Swal.fire({
                    title: 'Error!',
                    text: 'Something wrong while adding.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                })
            }
        });
    });

    $('#delete-image').on('submit', function (event) {
        event.preventDefault();
        var id = $('#delete-image input[name="id"]').val();
        $('#deleteEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/delete_memory_image.php',
            type: 'POST',
            dataType: 'json',
            data: { id: id },
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Image deleted.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getMemoryImagesAfterEditing();
            },
            error: function () {
                console.log('error');
                Swal.fire({
                    title: 'Error!',
                    text: 'Something wrong while delete.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                })
            }
        });
    });

    $('.table tbody').on('click', '.edit, .delete', function () {
        tr = $(this).closest('tr');
        const id = tr.find('td:eq(0)').text();
        if ($(this).hasClass('edit')) {
            $('#editEmployeeModal .modal-body input:eq(0)').val(id);
        } else if ($(this).hasClass('delete')) {
            $('#deleteEmployeeModal .modal-body input:eq(0)').val(id);
        }
    });

    getMemoryImages();
});