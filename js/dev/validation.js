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

    $("body").on('submit', '.login_form', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var el = $(this);
        el.find(".email_required").blur();
        el.find(".required").blur();

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
                        $(el).find('.login_button_submit').append(div);
                        div.slideDown(600).delay(1000).slideUp(function () {
                            $(this).remove();
                            window.location.href = $(el).attr('data-redirect');
                        });                       
                    } else {
                        var message = data.message.password;
                     
                        $('.server_error').html(message);
                    }
                }
            });
        }
    });
});


