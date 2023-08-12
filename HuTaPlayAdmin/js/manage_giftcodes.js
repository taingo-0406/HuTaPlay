$(document).ready(function () {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    function getGiftcodes() {
        $.ajax({
            url: '../database/admin/check_all_giftcodes.php',
            type: 'GET',
            dataType: 'json',
            success: function (gifts) {
                gifts = gifts.map(gift => ({
                    ...gift,
                    exchanged: Number(gift.exchanged)
                }));
                const select = $('<select class="form-control" name="name"></select>');

                gifts.forEach(function (gift) {
                    const exists = select.find('option[value="' + gift.gift_id + '"]').length > 0;

                    if (!exists) {
                        const option = $('<option></option>')
                            .attr('value', gift.gift_id)
                            .text(gift.gift_name);
                        select.append(option);
                    }
                });

                $('.gift-name').append(select);

                // initialize the DataTables plugin on the table
                const table = $('.table').DataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [
                        {
                            text: 'Add new giftcodes',
                            action: function () {
                                $('#addEmployeeModal').modal('show');
                            }
                        }
                    ],
                    data: gifts,
                    columns: [
                        { data: 'id' },
                        { data: 'gift_name' },
                        { data: 'code' },
                        {
                            data: 'exchanged',
                            render: function (data, type, row) {
                                return data ? 'Yes' : 'No';
                            }
                        },
                        { data: 'timestamp' },
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

    function getGiftcodesAfterEditing() {
        table = $('.table').DataTable();
        $.ajax({
            url: '../database/admin/check_all_giftcodes.php',
            type: 'GET',
            dataType: 'json',
            success: function (gifts) {
                gifts = gifts.map(gift => ({
                    ...gift,
                    exchanged: Number(gift.exchanged)
                }));

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
        const name = $('#edit-gift select[name="name"]').val();
        const code = $('#edit-gift input[name="code"]').val();
        const exchanged = $('#edit-gift select[name="exchanged"]').val();
        $('#editEmployeeModal').modal('hide');
        $.ajax({
            url: '../database/admin/edit_giftcode.php',
            type: 'POST',
            data: { id: id, name: name, code: code, exchanged: exchanged },
            success: function () {
                Swal.fire({
                    title: 'Success!',
                    text: 'Gift edited.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                })
                getGiftcodesAfterEditing();
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
        const name = $('#add-gift select[name="name"]').val();
        const codes = $('#add-gift textarea[name="code"]').val().split('\n');
        const exchanged = $('#add-gift select[name="exchanged"]').val();
        $('#addEmployeeModal').modal('hide');

        // Create an array to hold the AJAX requests
        var requests = [];

        // Send an AJAX request for each code
        codes.forEach(function (code) {
            var request = $.ajax({
                url: '../database/admin/add_giftcodes.php',
                type: 'POST',
                dataType: 'json',
                data: { name: name, code: code, exchanged: exchanged }
            });
            requests.push(request);
        });

        // Wait for all the requests to complete
        $.when.apply($, requests).then(function () {
            // All requests completed successfully
            Swal.fire({
                title: 'Success!',
                text: 'Gifts added.',
                icon: 'success',
                confirmButtonText: 'OK',
            })
            getGiftcodesAfterEditing();
        }, function () {
            // At least one request failed
            Swal.fire({
                title: 'Error!',
                text: 'Something wrong while adding.',
                icon: 'error',
                confirmButtonText: 'OK',
            })
            getGiftcodesAfterEditing();
        });
    });

    $('.table tbody').on('click', '.edit', function () {
        tr = $(this).closest('tr');
        // get the data from the table cells
        const id = tr.find('td:eq(0)').text();
        const code = tr.find('td:eq(2)').text();
        const exchanged = tr.find('td:eq(3)').text();
        // fill the modal's input fields with the data
        $('#editEmployeeModal .modal-body input:eq(0)').val(id);
        $('#editEmployeeModal .modal-body input:eq(1)').val(code);
        $('#editEmployeeModal .modal-body select[name="exchanged"]').val(exchanged === 'Yes' ? '1' : '0');
    });

    getGiftcodes();
});