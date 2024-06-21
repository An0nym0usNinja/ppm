export function modals() {
    // purchase order modal
    $('div[id^="order-card-"]').on("click", function () {
        let id = $(this).attr('id').split('-')[2];
        $('#order-modal-' + id).removeClass('hidden').addClass('flex');
        $('#curtain').addClass('curtain-expanded').removeClass('curtain-closed');
    });

    $('#curtain').on("click", function () {
        $('.purchase-order-modal').removeClass('flex').addClass('hidden');
        $('#curtain').addClass('curtain-closed').removeClass('curtain-expanded');
    });

    // tooltip trigger
    $('.tooltip-trigger').hover(function () {
        let id = $(this).attr('tooltip-id');
        $('#' + id).removeClass('hidden').addClass('fixed');
    }, function () {
        let id = $(this).attr('tooltip-id');
        $('#' + id).addClass('hidden').removeClass('fixed');
    });

    // delete modal
    $('*[id^="delete-button-"]').on("click", function () {
        let id = this.getAttribute('id').split('-')[2];
        $("#delete-modal-"+id).removeClass('hidden');
        setTimeout(function () {
            $("#curtain").addClass('curtain-expanded').removeClass('curtain-closed');
            $("#delete-modal-popup-"+id).removeClass('modal-close').addClass('modal-popup');
        }, 300);
    });
    $('#curtain, button[id^="delete-modal-cancel-"]').on("click", function () {
        $("#curtain").addClass('curtain-closed').removeClass('curtain-expanded');
        $("*[id^='delete-modal-popup-']")
            .removeClass('modal-popup')
            .removeClass('modal-close')
            .addClass('modal-close');
        setTimeout(function () {
            $("*[id^='delete-modal-']")
                .removeClass('hidden')
                .addClass('hidden');
            $("*[id^='delete-modal-popup-']")
                .removeClass('hidden');
        }, 200);
    });

    // unlink modal
    $('*[id^="unlink-button-"]').on("click", function () {
        let id = this.getAttribute('id').split('-')[2];
        $("#unlink-modal-"+id).removeClass('hidden');
        $("#curtain").addClass('curtain-expanded').removeClass('curtain-closed');
        $("#unlink-modal-popup-"+id).removeClass('modal-close').addClass('modal-popup');
    });
    $('#curtain, button[id^="unlink-modal-cancel-"]').on("click", function () {
        let id = this.getAttribute('id').split('-')[3];
        $("#curtain").addClass('curtain-closed').removeClass('curtain-expanded');
        $("#unlink-modal-popup-"+id).removeClass('modal-popup').addClass('modal-close');
        $("*[id^='unlink-modal-']").removeClass('hidden').addClass('hidden');
        $("*[id^='unlink-modal-popup-']").removeClass('hidden');
    });
}
