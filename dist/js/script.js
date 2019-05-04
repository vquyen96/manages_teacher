$(document).ready(function () {
    //Date picker
    $('.select2').select2();

    $(document).on('click', '#btn-add-gvnc', function () {
        var prevEle = $(this).prev().find('.select2');
        prevEle.select2().select2('destroy');
        var html = $(this).prev().clone();
        prevEle.removeAttr('data-select2-id');
        $(html).insertBefore($(this));
        $('.select2').select2();
    });
    $(document).on('click', '#btn-add-svnc', function () {
        var prevEle = $(this).prev().find('.select2');
        prevEle.select2().select2('destroy');
        var html = $(this).prev().clone();
        prevEle.removeAttr('data-select2-id');
        $(html).insertBefore($(this));
        $('.select2').select2();
    });
});