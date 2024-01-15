export function cellEdit() {
    // Editable text cell
    $(".editable-cell-text").on("focusout", function () {
        let value = $(this).val();
        let field = $(this).attr('name');
        let id    = $(this).attr('part-id');

        setTimeout(function () {
            $.ajax({ // route('parts.update', $part->id)
                type: 'POST',
                url: '/parts/update/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    field: field,
                    value: value
                }
            });
        }, 200);
    });

    // Editable checkbox cell
    $(".editable-cell-boolean").on("click", function () {
        let value = $(this).is(':checked') ? 1 : 0;
        let field = $(this).attr('name');
        let id    = $(this).attr('part-id');

        setTimeout(function () {
            $.ajax({ // route('parts.update-checkbox', $part->id)
                type: 'POST',
                url: '/parts/update-checkbox/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    field: field,
                    value: value
                },
                success: function (data) {
                    $("#" + data['part_id'] + "-status").html(data['status']);
                    $("#" + data['part_id'] + "-" + data['stamp_field']).html(data['stamp_value']);
                    
                    switch (data['status']) {
                        // warehouse index page
                        case 'Waiting on Raw Part':
                            $("#" + data['part_id'] + "-raw_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-treatment_1_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_2_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-completed_part_received input").attr('disabled', true);
                            break;
                        case 'Waiting on Treatment 1':
                            $("#" + data['part_id'] + "-raw_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-treatment_1_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-treatment_2_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-completed_part_received input").attr('disabled', true);
                            break;
                        case 'Waiting on Treatment 2':
                            $("#" + data['part_id'] + "-raw_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_1_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-treatment_2_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-completed_part_received input").attr('disabled', true);
                            break;
                        case 'Waiting on Final Part':
                            $("#" + data['part_id'] + "-raw_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_1_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_2_part_received input").removeAttr('disabled');
                            $("#" + data['part_id'] + "-completed_part_received input").removeAttr('disabled');
                            break;
                        case 'Part Received':
                            $("#" + data['part_id'] + "-raw_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_1_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-treatment_2_part_received input").attr('disabled', true);
                            $("#" + data['part_id'] + "-completed_part_received input").removeAttr('disabled');
                            break;
                    }
                }
            });
        }, 200);
    });

    // Editable dropdown cell
    $(".editable-cell-dropdown").on("change", function () {
        let value = $(this).val();
        let field = $(this).attr('name');
        let id    = $(this).attr('part-id');

        setTimeout(function () {
            $.ajax({ // route('parts.update', $part->id)
                type: 'POST',
                url: '/parts/update/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    field: field,
                    value: value
                }
            });
        }, 200);
    });
}