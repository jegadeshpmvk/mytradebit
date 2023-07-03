$(function () {

    $("body").on("blur", ".email_required", function () {
        var field_val = $(this).val();
        var email_Reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        console.log(field_val);
        if (field_val.length === 0) {
            $(this).closest(".form_group").addClass('error_input');
        } else if (!email_Reg.test(field_val)) {
            $(this).closest(".form_group").addClass('error_input');
        } else {
            $(this).closest(".form_group").removeClass('error_input');
        }
    });

    $("body").on("blur", ".required", function () {
        var field_val = $(this).val();
        if (field_val.length === 0) {
            $(this).closest(".form_group").addClass('error_input');
        } else {
            $(this).closest(".form_group").removeClass('error_input');
        }
    });

    $("body").on('submit', '.login_form, .register_form, .forgot_password', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var el = $(this);
        // if (el.find(".email_required").length) {
        //     el.find(".email_required").blur();
        // }
        // if (el.find(".required").length) {
        //     el.find(".required").blur();
        // }

        if (el.find('.has-error').length === 0) {
            var el = this,
                values = $(el).serialize(),
                button = $(this).find('button');
            values += "&ajaxSubmit=true";
            button.addClass('loading');
            $.ajax({
                url: el.action,
                type: 'post',
                data: values,
                dataType: "json",
                success: function (data) {
                    button.removeClass('loading');
                    if (data.status === 200) {
                        el.reset();
                        var div = $('<div/>', {
                            'class': 'thank login-thank',
                            'html': '<span>' + data.message + '</span>'
                        });
                        $(el).find('.button_submit').append(div);
                        div.slideDown(600).delay(1000).slideUp(function () {
                            $(this).remove();
                            if ($(el).attr('data-redirect')) {
                                window.location.href = $(el).attr('data-redirect');
                            }
                        });
                    } else {
                        var message = data.message;
                        $.each(message, function (index, value) {
                            $('.' + index).closest('.form-group').removeClass('has-success');
                            $('.' + index).closest('.form-group').addClass('has-error');
                            $('.' + index).next('.help-block').html(value);
                        });
                    }
                }
            });
        }
    });
});


