$(document).ready(function () {
    //Date picker


    setTimeout(function () {
        $('.alert-flash').css('right', '-500px');
    }, 5000);

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

    $('.slide-up').slideUp();
    $(document).on('click', '.btn-tai-khoan', function () {
        // alert("ok");
        $('.form-tai-khoan').slideToggle();
    });

    $('.img-file').click(function(){
        $(this).prev().click();
    });

    $(document).on('click', '.btn-change-pass', function () {
        $(this).hide()
        $('.form-change-pass').show();

    });




});

// Hàm thay ảnh và hiển thị ảnh sau khi chọn
function changeImg(input){
    var inputFile = $(this);

    console.log($(input).next());
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if(input.files && input.files[0]){
        var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function(e){
            //Thay đổi đường dẫn ảnh
            // $('#avatar').attr('src',e.target.result);
            $(input).next().attr('src',e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
    }
}