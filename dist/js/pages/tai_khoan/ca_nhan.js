$(document).ready(function () {
    console.log("ok");
    $('#form-tai-khoan').submit(function (e) {
        var name = $(this).find('input[name="ten_dang_nhap"]');
        var ho_ten = $(this).find('input[name="ho_ten"]');
        var pass = $(this).find('input[name="mat_khau"]');
        var re_pass = $(this).find('input[name="re_mat_khau"]');
        var error = 0;
        $(".txt-error").remove();
        var passRegExp = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
        if (name.val().length < 1) {
            name.after('<span class="txt-error">Tên đăng nhập không được để trống</span>');
            error++;
        }
        if (ho_ten.val().length < 1) {
            ho_ten.after('<span class="txt-error">Họ và tên không được để trống</span>');
            error++;
        }
        if (pass.val().length > 0) {

            if (re_pass.val() != pass.val() ) {
                re_pass.after('<span class="txt-error">Xác minh mật khẩu không đúng</span>');
                error++;
            }
            if (!passRegExp.test(pass.val())) {
                pass.after('<span class="txt-error">Mật khẩu phải nhiều hơn 8 ký tự gồm Chữ hoa, chữ thường và ký tự số</span>');
                error++;
            }
        }
        if (error != 0) {
            e.preventDefault();
        }
    });
});
