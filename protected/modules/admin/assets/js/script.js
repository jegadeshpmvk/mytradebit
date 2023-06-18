$(function () {
    $('body').on('click', 'a[data-scroll]', function (e) {
        e.preventDefault();
        var el = $(this),
                sel = el.data('scroll');
        $('html, body').animate({
            'scrollTop': $(sel).offset().top - $(".header").outerHeight() - 30
        }, 1000);
    });
    /**********************
     SEARCH BAR
     **********************/
    $('body').on('click', 'a', function (e) {
        e.stopPropagation();
    });
    $('body').on('click', '.options a.fa-search, .search-bar a.fa-arrow-left', function () {
        $('html').toggleClass('has-search');
    });
    $('body').on('click', '.search-bar a.fa-search', function () {
        $('.search-form form').submit();
    });
    $('body').on('click', '.search-bar a.fa-refresh', function () {
        $('.search-form input[type="text"], .search-form select').val('');
    });

    /**********************
     SORTING
     **********************/
    $('body').on('click', '.options a.fa-reorder', function (e) {
        e.preventDefault();
        sort.init('.table tbody');
        $('html').addClass('has-sort');
    });
    /**********************
     REPEATER
     **********************/
    repeater.sortable();
    $('body').on('click', 'a.repeater-next-add', function (e) {
        e.preventDefault();
        var list = $(this).closest('.repeater');
        var target = $(this).closest('li');
        var rel = list.data('rel');
        var template = $('.templates [data-for="' + rel + '"]').html();
        var typeArr = ["slider", "grid", "small_icon", "feature-grid"];

        if (typeArr.indexOf(rel) >= 0) {
            template = flexibleContent.replaceImageUniqueId(template);
        }

        $(template).css('display', 'none').insertAfter(target).slideDown(function () {
            repeater.order(this);
        });
    });
    $('body').on('click', 'a.repeater-del', function (e) {
        e.preventDefault();
        var block = $(this).closest('li');
        rep = $(this).closest('.repeater');
        block.slideUp(function () {
            $(this).remove();
            repeater.order(rep);
        });
    });
    $('body').on('click', 'a.repeat-add', function (e) {
        e.preventDefault();
        var list = $(this).prev('.repeater');
        var rel = list.data('rel');
        var template = $('.templates [data-for="' + rel + '"]').html();
        var typeArr = ["slider", "grid", "small_icon", "feature-grid"];
        if (typeArr.indexOf(rel) >= 0) {
            template = flexibleContent.replaceImageUniqueId(template);
        }

        $(template).css('display', 'none').appendTo(list).slideDown(function () {
            repeater.order(this);
        });
    });

    $('body').on('click', 'a.repeater-up', function (e) {
        e.preventDefault();
        var block = $(this).closest('li'),
                prev = block.prev('li');
        if (prev.length) {
            block.insertBefore(prev);
            repeater.order(this);
        }
    });

    $('body').on('click', 'a.repeater-down', function (e) {
        e.preventDefault();
        var block = $(this).closest('li'),
                next = block.next('li');
        if (next.length) {
            block.insertAfter(next);
            repeater.order(this);
        }
    });

    $('body').on('blur', '.repeater input, .flexible-content input', function () {
        $(this).attr('value', $(this).val());
    });
    $('body').on('blur', '.repeater textarea, .flexible-content textarea', function () {
        $(this).html($(this).val());
    });
    $('body').on('change', '.repeater input[type="checkbox"], .flexible-content input[type="checkbox"]', function () {
        $(this).attr('checked', $(this).is(":checked"));
    });
    $('body').on('blur', '.repeater select, .flexible-content select', function () {
        $(this).find('option').removeAttr('selected');
        $(this).find(":selected").attr('selected', $(this).val());
    });

    /******************************************
     DISPAYING FIELD BASED ON DROP DOWN RESULT
     *******************************************/
    $('body').on('change', 'select.block-change', function (e) {
        var blockgroup = $(this).data('group'),
                groupel = $('.' + blockgroup);
        sel = '.' + blockgroup + '.' + this.value,
                el = $(sel);
        groupel.fadeOut(0);
        if (this.value !== '')
            el.fadeIn(0);
    });

    $('body').on('change', '.rsvp_button  input', function (e) {
        e.preventDefault();
        var val = $(this).val();
        $('.rsvp_type').removeClass('active');
        $('.rsvp_type.' + val).addClass('active');
    });

    $('body').on('change', '.radio_type  input', function (e) {
        e.preventDefault();
        var val = $(this).val();
        $('.voucher_type').removeClass('active');
        $('.voucher_type.' + val).addClass('active');
    });

    $('body').on('change', '.internal_rsvp  input', function (e) {
        e.preventDefault();
        var val = $(this).val();
        $('.internal_rsvp_type').removeClass('active');
        $('.internal_rsvp_type.' + val).addClass('active');
    });

    /**********************
     MULTI SELECT
     **********************/
    $('.multiselector select').each(function () {
        page.dropdowns[this.id + '_ref'] = $(this).dropdown({
            multiSelect: true,
            onChange: function (option, element) {
                var id = element.id,
                        value = $.trim($(element).val()),
                        hid = $(element).data('hidden'),
                        box = $(element).closest('.multiselector'),
                        dropDown = page.dropdowns[element.id + '_ref'];
                if (value != '') {
                    $('#' + element.id + '_wrapper').before('<div class="tag" id="' + id + value + '">' + $('#' + id + ' option:selected').text() + '<input type="hidden" name="' + hid + '" value="' + value + '" /><a data-id="' + value + '" class="remove fa fa-times-circle"></a></div>');
                    dropDown.disableOption(value);
                    dropDown.selectOption('');
                }
            }
        });
    });

    $('body').on('click', '.widgets_title', function () {
        $(this).next().slideToggle();
        $(this).toggleClass('collapse');
    })

    $('body').on('change', '.brand_ajax', function (e) {
        e.preventDefault();
        var id = this.value;
        var html = '';
        $('.shop_lists .select2-multi-list').select2("destroy");
        $.ajaxq("get-shops", {
            url: '/admin/offer/shops',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                if (data.status == 200) {
                    $.each(data.list, function (index, value) {
                        html += '<option value="' + index + '">' + value + '</option>';
                    });
                    $('.shop_lists select').html('');
                    $('.shop_lists select').append(html);
                    $('.shop_lists .select2-multi-list').select2();
                } else {
                    $('.shop_lists select').html('');
                    $('.shop_lists select').append(html);
                    $('.shop_lists .select2-multi-list').select2();
                }
            },
            error: function () {
                alert('Error in form');
            },
            complete: function () {

            }
        });
    })

    $('body').on('change', '.rsvp_list_select', function (e) {
        e.preventDefault();
        var state = this.value,
                url = $(this).attr('data-url'),
                id = $(this).attr('data-id'),
                el = this;
        $.ajaxq("get-rsvp", {
            url: url,
            type: 'post',
            data: {id: id, state: state},
            dataType: 'json',
            success: function (data) {
                if (data.status == 200) {
                    $(el).attr('class', 'rsvp_list_select');
                    $(el).addClass(data.text);
                    alertify.success('Status updated sucessfully');
                }
            },
            error: function () {
                alertify.error('Error in form');
            },
            complete: function () {

            }
        });
    })

    $('body').on('click', '.select_winner', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
                url = $(this).attr('data-url'),
                name = $(this).attr('data-name'),
                html = '';

        html += '<div class="dropdown-create-option">';
        html += '<div class="winner">';
        html += '<div class="winner_title">Competition winner<a class="fa fa-remove winner_close" href="#" onclick="window.parent.blogIframe.close();"></a></div>';
        html += '<div class="winner_body">';
        html += '<div class="winner_text">You are about to pick ' + name + ' as winner of this competition</div>';
        html += '<div class="winner_buttons"><a class="button" href="' + url + '">Continue</a><a class="button button_cancel"  onclick="window.parent.blogIframe.close();">Cancel</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $('body').append(html).addClass('has-iframe');
    });

    $('body').on('change', '.categories_select', function (e) {
        e.preventDefault();
        var val = this.value,
                f_date = $(this).attr('data-from'),
                t_date = $(this).attr('data-to'),
                href = $('.download_redeemed').attr('href'),
                id = page.urlvars(href)["id"],
                res = href.replace("id=" + id, "id=" + val);
        $('.top_offers').addClass('show');
        $.ajaxq("get-category", {
            url: 'reports/category',
            type: 'post',
            data: {val: val, f_date: f_date, t_date: t_date},
            dataType: 'json',
            success: function (data) {
                if (data.status == 200) {
                    $('.top_offers').html('');
                    $('.top_offers').append(data.list);
                    $('.top_offers').removeClass('show');
                    $('.download_redeemed').attr('href', res);
                    alertify.success('Sucessfully');
                }
            },
            error: function () {
                alertify.error('Error in form');
            },
            complete: function () {

            }
        });
    })

    page.load();
    page.table();
});

//Repeater
var repeater = {order: function (el) {
        var isChild = false;
        if (!$(el).hasClass('repeater')) {
            el = $(el).closest('.repeater');
        }

        if (el.closest('.repeater-item').length)
            isChild = el.closest('.repeater-item').attr('data-key');
        if (el.closest('.flexible-item').length)
            isChild = el.closest('.flexible-item').attr('data-key');
        $(el).find('> li').each(function (i) {
            repeater.destroyEditor(this);
            flexibleContent.destroySelect2($(this).find(".select2-dropdown-links"));
            flexibleContent.destroySelect2($(this).find('.select2-multi-list'));
            flexibleContent.destroySelect2($(this).find('.select2-single-list'));
            var item = $(this).find('> .repeater-item'),
                    oldid = item.attr('data-key'),
                    html = item.html(),
                    regex,
                    id = i;
            var nth = 0;
            html = html.replace(/-\d+-/g, function (match, i, original) {
                nth++;
                var div = isChild === false ? 1 : 2;
                return '-' + ((nth % div == 0) ? id : isChild) + '-';
            });
            nth = 0;
            html = html.replace(/\[(\d)+\]/g, function (match, i, original) {
                nth++;
                var div = isChild === false ? 1 : 2;
                return '[' + ((nth % div == 0) ? id : isChild) + ']';
            });
            //Replace HTML
            $(this).find('> .repeater-item').attr('data-key', i).html(html);
            repeater.subRepeatOrder($(this));
            flexibleContent.makeImageUploadable(this);
            repeater.datePickerInit(this);
            //add editors
            repeater.initEditor(this);
            flexibleContent.select2Links($(this).find(".select2-dropdown-links"));

            flexibleContent.makeMultiSelect($(this).find('.select2-multi-list'));
            flexibleContent.makeSingleSelect($(this).find('.select2-single-list'));
        });
        //Make textarea autoresize
        $(el).find('textarea').autosize();
        //Make it sortable
        this.sortable();
    },
    sortable: function () {
        $('.repeater').each(function () {
            $(this).sortable({
                handle: $(this).find('.drag'),
                helper: 'clone',
                update: function (event, ui) {
                    repeater.order(ui.item);
                }
            });
        });
    },
    subRepeatOrder: function (el) {
        var rep = el.find('.repeater');
        if (rep.length) {
            rep.each(function () {
                repeater.order($(this));
            });
        }
    },
    datePickerInit: function (el) {
        var inpDates = $(el).find('.hasDatepicker');
        if (inpDates.length) {
            $(inpDates).each(function () {
                $(this).removeClass('hasDatepicker').datepicker({
                    onSelect: function (selectedDate) {
                        // custom callback logic here
                        $(this).attr('value', selectedDate);
                    }
                });
            });
        }
    },
    destroyEditor: function (el) {
        var txtArea = $(el).find('.repeater-widget-editor');
        if ($(txtArea).length) {
            $(txtArea).attr('data-html', $R(txtArea[0], 'source.getCode'));
            $(txtArea).attr('data-name', $(txtArea).attr("name"));
            $R(txtArea[0], 'destroy');
        }
    },
    initEditor: function (el) {
        var txtArea = $(el).find('.repeater-widget-editor');
        if ($(txtArea).length) {
            //$('.model-form textarea.repeater-widget-editor').each(function (e) {
            $(txtArea).attr("name", $(txtArea).attr("data-name"));
            $(txtArea).removeAttr("data-name");

            if ($(txtArea).attr('data-html')) {
                $(txtArea).val($(txtArea).attr('data-html'));
            }


            $R(txtArea[0], {
                plugins: ['source', 'table', 'alignment'],
                focus: false,
                formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                buttons: ['format', 'bold', 'italic', 'underline', 'link', 'lists', 'html'],
                linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
            });
            //});
        }
    },
    destroyFullEditor: function () {
        $('.model-form textarea.repeater-widget-editor').each(function (e) {
            $(this).attr('data-html', $R(this, 'source.getCode'));
            $(this).attr('data-name', $(this).attr("name"));
            $R(this, 'destroy');
        });
    },
    initFullEditor: function () {
        if ($('.model-form textarea.repeater-widget-editor').length) {
            $('.model-form textarea.repeater-widget-editor').each(function (e) {
                $(this).attr("name", $(this).attr("data-name"));
                $(this).removeAttr("data-name");

                if ($(this).attr('data-html')) {
                    $(this).val($(this).attr('data-html'));
                }

                $R(this, {
                    plugins: ['source', 'table', 'alignment'],
                    focus: false,
                    formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                    buttons: ['format', 'bold', 'italic', 'underline', 'link', 'lists', 'html'],
                    linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                });
            });
        }
    },
};
//Page functions
var page = {upload_object: {}, dropdowns: {}, timer: 0,
    saveTimer: 0,
    check: function () {
        if (!Modernizr.history)
            window.location = '/upgrade/browser';
    },
    load: function () {
        //Display alerts
        if ($('.header .alert').length) {
            $('.header .alert').slideDown().delay(5000).slideUp(function () {
                $(this).remove();
            });
        }
        //Scroll to Nav
        if ($('ul.nav .active').length) {
            if ($('ul.nav .active').offset().top > ($(window).height() - 150))
                $('.panel.left').scrollTop($('ul.nav .active').offset().top - 200);
        }
        //Initialize sorting
        sort.init();
        //Setup blocks
        $('select.block-change').change();
        $('input.block-change').change();
        //Autogrow textarea
        $('textarea').not('.html').autosize();
        //Enable HTML editor
        if ($('textarea.html').length) {
            $('textarea.html').each(function (e) {
                if ($(this).hasClass('special')) {
                    $(this).redactor({
                        plugins: ['source'],
                        focus: false,
                        formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                        buttons: ['format', 'bold', 'italic', 'link', 'lists', 'html'],
                        linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                    });
                } else {
                    $(this).redactor({
                        plugins: ['source', 'table', 'alignment'],
                        focus: false,
                        buttons: ['bold', 'underline', 'link', 'html'],
                        linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                    });
                }
            });
        }
        //Render custom dropdowns
        $('.richdropdown').each(function () {
            page.dropdowns[this.id + '_ref'] = $(this).dropdown();
        });
        flexibleContent.adjustLayoutGrid();
        page.resize();
        $('.related-sidebar-type').each(function () {
            relatedWidget.init(this);
        });
    },
    resize: function () {
        //GridView
        if ($('.grid-view').length) {
            $('.full-row-edit').css('width', ($('.content').width() - 20) + 'px');
            $('.full-row-click').each(function () {
                var hei = $(this).closest('td').outerHeight();
                $(this).css('height', hei);
            });
        }

        if ($(".image-cropper").length) {
            cropper.objectFit();
        }

        flexibleContent.adjustLayoutGrid();
    },
    table: function () {
        $('.table.table-striped.table-bordered th').each(function () {
            var text = $(this).find('a').html(),
                    a = $(this).find('a'),
                    span = '<span>' + text + '</span>';
            a.html('');
            a.append(span);
        })

    },
    urlvars: function (href) {
        var vars = [], hash;
        var hashes = href.slice(href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
};
//Sorting plugin
var sort = {cache: '', init: function (selector) {
        this.cache = $(selector).html();
        $(selector).each(function () {
            $(this).sortable({
                placeholder: "drop-placeholder",
                revert: true, start: function (e, ui) {
                    ui.placeholder.width(ui.helper.width());
                }
            });
        });
    },
    reset: function (selector) {
        $(selector).html(this.cache);
        this.cache = '';
    },
    destroy: function (selector) {
        $(selector).sortable("destroy");
    },
    save: function (el, selector) {
        serial = $(selector).sortable("serialize", {
            key: "items[]",
            attribute: "data-sort"
        });
        $.ajax({
            url: el.href,
            type: "post",
            data: serial,
            success: function () {
                sort.destroy(selector);
                $('html').removeClass('has-sort');
                alertify.success("The order was saved successfully.");
            },
            error: function () {
                sort.destroy(selector);
                alertify.error("We are unable to set the sort order at this time.  Please try again in a few minutes.");
            }
        });
    }
};