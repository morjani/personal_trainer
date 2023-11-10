function initDatatable(table, cols, config, whenDraw , btns){
    table = $(table);
    cols = cols || [];
    config = config || {};
    whenDraw = whenDraw || function(){};

    var datatable_settings = {

        processing      : true,
        serverSide      : true,
        columns         : cols,
        searching       : true,
        order           : [[0, 'desc']],
        pageLength: 10,
        buttonss         : [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: '',
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: '',
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: '',
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: '',
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: '',
                }
            },
            'colvis'
        ],
        // buttons : [],
        columnDefs      : [],
        responsive      : true,
        "pagingType": "full_numbers",
        "oLanguage": {
            "oPaginate": {
                "sFirst": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>',
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                "sLast": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            "sProcessing": "<img src='/assets/images/loading.gif'>",
        }
    };

    $.each(cols, function(i, col){
        if('orderable' in col && !col.orderable){
            datatable_settings.columnDefs.push({targets:i, orderable:false});
        }
        if('searchable' in col && !col.searchable){
            datatable_settings.columnDefs.push({targets:i, searchable:false});
        }
    });


    $.each(config, function(i, e){
        datatable_settings[i] = e;
    });

    datatable_settings.preDrawCallback = function(){
        return;
        (function(table, dt){
            var holder = table.closest('.dt_block').find('.admb_footer');
            if(holder.find('.fordatatable_info').length === 0) holder.append('<div><p class="fordatatable_info"></p></div>');
            if(holder.find('.pagination_div').length === 0) holder.append('<div class="pagination_div"></div>');

            holder.find('.fordatatable_info').html('Initializing Data..');
            table.closest('.dt_block').find('.admb_body').addClass('loading');

        })(table, datatable);
    };
    datatable_settings.drawCallback = function(){
        whenDraw(table, datatable);
        return;
        (function(table, dt){

            var holder = table.closest('.dt_block').find('.admb_footer');
            if(holder.find('.fordatatable_info').length === 0) holder.append('<div><p class="fordatatable_info"></p></div>');
            if(holder.find('.pagination_div').length === 0) holder.append('<div class="pagination_div"></div>');

            holder.find('.fordatatable_info').html(
                dt.data().length > 1
                    ? 'Showing ' + dt.data().length + ' from ' + dt.settings()[0].json.recordsTotal + ' records'
                    : (dt.data().length < 1
                        ? 'No records to show'
                        : 'Showing one out of ' + dt.settings()[0].json.recordsTotal + ' records')
            );
            holder.parent().find('.loading').removeClass('loading');

            holder.find('.pagination_div').html(holder.parent().find('.dataTables_paginate ul'));

        })(table, datatable);
    };
    datatable_settings.initComplete = function(set){


        return;
        (function(table, dt){


            var tools_holder = table.closest('.dt_block').find('.admb_head > div'),
                buttons = {
                    btn_search : $('<button type="button" title="Search"><i class="icon-search"></i></button>'),
                    btn_row : $('<button type="button" title="Change the number of rows in page"><i class="icon-list-numbered"></i><b>10</b><ul class="dt_numrows_menu"><li>10</li><li>25</li><li>50</li><li>100</li></ul></button>'),
                    btn_cols : $('<button type="button" title="Show/Hide columns"><i class="icon-eye-blocked"></i></button>'),
                    btn_export : $('<button type="button" title="Export"><i class="icon-download"></i><ul class="dt_export_menu">' +
                        '<li><i class="icon-file-pdf"></i> PDF File</li>' +
                        '<li><i class="icon-file-excel"></i> Excel Sheet</li>' +
                        '<li><i class="icon-file-openoffice"></i> CSV File</li>' +
                        '<li class="separator"></li>' +
                        '<li><i class="fa fa-file-excel-o"></i> <b>Export ALL as Excel File</b></li>' +
                        '</ul></button>'),
                    btn_print : $('<button type="button" title="Print"><i class="icon-printer"></i></button>'),
                    btn_refresh : $('<button type="button" title="Refresh"><i class="icon-loop2"></i></button>'),
                },
                sep = $('<div class="dt_menu_sep"></div>'),
                search = $('<div class="dt_search_holder"><input type="search" title="search" placeholder="Search.."><button type="button"><i class="fa fa-close"></i></button></div>'),
                settings = dt ? dt.settings()[0] : {},
                cols = settings.aoColumns;

            if(!tools_holder.hasClass('initialized')){
                init();
            }

            function init(){
                if(!liracoin.preferences.datatable.scroller){
                    buttons.btn_row.find('b').html((settings._iDisplayLength || 10));
                    buttons.btn_row.on('click', function(){
                        var ul = $(this).find('ul')
                            .find('li')
                            .on('click', function(){
                                settings._iDisplayLength = $(this).html();
                                buttons.btn_row.find('b').html($(this).html());
                                (dt || {draw:function(){}}).draw();

                            })
                            .end();

                        if($(this).toggleClass('opened').hasClass('opened')){
                            ul.show().animate({top : '100%', opacity : 1})
                        }else{
                            ul.animate({top : '100%', opacity : 0}, function(){$(this).hide()})
                        }

                    });
                }else{
                    buttons.btn_row = $('');
                }


                buttons.btn_print.on('click', function(){
                    table.closest('.dataTables_wrapper').find('.buttons-print').trigger('click');
                });

                buttons.btn_refresh.on('click', function(){
                    dt.ajax.reload();
                });

                buttons.btn_export.find('ul li')
                    .on('click', function(){
                        if($(this).find('i').hasClass('icon-file-pdf')){

                            table.closest('.dataTables_wrapper').find('.buttons-pdf').trigger('click');
                        }else if($(this).find('i').hasClass('icon-file-excel')){

                            table.closest('.dataTables_wrapper').find('.buttons-excel').trigger('click');
                        }else if($(this).find('i').hasClass('icon-file-openoffice')){

                            table.closest('.dataTables_wrapper').find('.buttons-csv').trigger('click');
                        }else if($(this).find('i').hasClass('fa-file-excel-o')){
                            export_table(table, settings);
                        }
                    });
                buttons.btn_export.on('click', function(){
                    var ul = $(this).find('ul');

                    if($(this).toggleClass('opened').hasClass('opened')){
                        ul.show().animate({top : '100%', opacity : 1})
                    }else{
                        ul.animate({top : '100%', opacity : 0}, function(){$(this).hide()})
                    }

                });

                var cols_list = $('<ul></ul>');
                $.each(cols, function(){
                    cols_list.append(
                        $('<li data-name="'+ this.name +'">'+ this.title +'</li>')
                            .addClass(this.bVisible ? 'active' : '')
                            .on('click', function(){
                                $(this).toggleClass('active');
                                dt.column(this.dataset.name + ':name')
                                    .visible($(this).hasClass('active'));
                            })
                    ).append($('<div class="list_overalshadow"></div>').on('click', function(){
                        cols_list.animate({top : '150%', opacity : 0}, function(){
                            $(this).hide().parent().removeClass('opened');
                        })
                    }));
                });
                buttons.btn_cols.append(cols_list.addClass('dt_colslist_menu'));
                buttons.btn_cols.on('click', function(){
                    if(!$(this).hasClass('opened')){
                        $(this).addClass('opened');
                        cols_list.show().animate({top : '100%', opacity : 1});
                    }
                });

                $.each(buttons, function(i, b){
                    tools_holder.append(
                        b
                            .on('mouseenter', function(){
                                b.append(
                                    $('<span>'+b.attr('title')+'</span>')
                                        .css({right : '100%', opacity : 0})
                                        .stop().animate({right : '50%', opacity : 1})
                                )
                            })
                            .on('mouseleave', function(){
                                $(this).find('span').stop().animate({right : '100%', opacity : 0}, function(){
                                    $(this).remove();
                                })
                            })
                    );
                });
                buttons.btn_print.after(sep.clone());
                buttons.btn_search.after(sep.clone());

                search.find('button').on('click', function(){
                    search.find('input').val('').trigger('change');
                    search.animate({top: 50, opacity : 0}, function(){
                        $(this).hide();
                        buttons.btn_search.removeClass('opened');

                    });
                }).end().find('input').on('change keyup', function(){
                    table.closest('.dataTables_wrapper').find('input[type="search"]').val(this.value).trigger('keyup');
                });
                buttons.btn_search.append(search).on('click', function(){
                    if($(this).hasClass('opened')) return false;
                    $(this).addClass('opened');
                    search.show()
                        .css({opacity : 0, top : 40})
                        .animate({top: 30, opacity : 1});
                });
                $.each(btns || [],function (i,b) {

                    var revok_access = dt.ajax.json();
                    if(! 'id' in b) b.id = '_';
                    revok_access = 'buttons' in revok_access && b.id in revok_access.buttons && revok_access.buttons[b.id] === false;
                    if(revok_access) return true;

                    var _btn = $('<a href="" class="datatable_link_action" title=""><i class=""></i> <span></span> </a>');
                    _btn
                        .attr('title', b.title)
                        .find('span').html(b.title).end()
                        .find('i'). addClass(b.icon).end()
                        .appendTo(tools_holder);
                    if(typeof b.action === 'string'){
                        _btn.attr('href', b.action);
                    }else{
                        _btn.attr('href', 'javascript:void(0);').on('click', b.action);
                    }
                    //tools_holder.find('button').first().before(_btn);
                });

                tools_holder.addClass('initialized');
                if(liracoin.preferences.datatable.scroller){
                    $('.dataTables_scrollBody').slimScroll(ssc_options);
                }
            }


        })(table, datatable);
    };


    var datatable = table.DataTable(datatable_settings);


    // if(('context' in ifes) === false) ifes.context = {};
    // if(('datatables' in ifes.context) === false) ifes.context.datatables = [];
    // ifes.context.datatables.push(datatable);
    return datatable;
}

function randomID () {
    var S4 = function() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

var modalAjax = function (url, options) {

    var loader= '/assets/images/load_modal.gif';
    var defaults = {
            title: 'Modal',
            header_close: true,
            footer_ok: true,
            footer_cancel: true,
            very_small: false,
            close_outsid: false,
            size_md: false,
            size_lg: false,
            size_xlg: false,
            ok: 'OK',
            cancel: 'Fermer',
            error_msg: 'impossible d\'afficher cette page, veuillez réessayer plus tard.',
            sucess_msg: 'Données enregistrées avec succès!',
            always_close: true,
            show_header: true,
            show_footer: true,
            post_data: {},
            onLoad: function (data, modal) {
            },
            onOk: function (modal, loader_, modal_sucess, modal_error) {
            },
            onCancel: function (modal) {
            },
            onClose: function (e) {
            },
        },
        settings = jQuery.extend({}, defaults, options);
    settings.post_data.ajax = 'true';




    var modal = jQuery('<div id="" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">' +
            '<div class="modal-dialog gl-modal-wc"> <div class="modal-content"> <div class="modal-header">' +
            '<h4 class="modal-title"></h4> </div> <div class="modal-body"></div>' +
            '<div class="modal-footer">' +
            '</div> </div> </div> </div>'),

        header_close = jQuery('<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'),
        footer_ok = jQuery('<button type="button" id="modal_dialog_ok" class="btn btn-info">Ok</button>'),
        footer_cancel = jQuery('<button type="button" id="modal_dialog_cancel" data-bs-dismiss="modal" class="btn btn-info">' +
            '<span class="md-click-circle md-click-animate"></span>Cancel</button>'),
        id = randomID(20, 'crm_modal'),
        modal_error = jQuery('<div class="modal_fail"><span class="fa fa-close"></span> <span>' + settings.error_msg + '</span></div>'),
        modal_sucess = jQuery('<div class="modal_sucess"><span class="fa fa-check"></span> <span>' + settings.sucess_msg + '</span></div>'),
        loader_ = jQuery('<div class="modal_loader text-center"><img src="'+loader+'" style="width: 100px">' +
            '</div>' +
            +'<span>En cours...</span></div>')

    ;


    if (settings.very_small) {
        modal.addClass('bs-modal-sm').find('.modal-dialog').removeClass('gl-modal-wc').addClass('modal-sm');
    }
    if (settings.size_md) {
        modal.addClass('bs-modal-md').find('.modal-dialog').removeClass('gl-modal-wc').addClass('modal-md');
    }
    if (settings.size_lg) {
        modal.addClass('bs-modal-lg').find('.modal-dialog').removeClass('gl-modal-wc').addClass('modal-lg');
    }
    if (settings.size_xlg) {
        modal.addClass('bs-modal-xl').find('.modal-dialog').removeClass('gl-modal-wc').addClass('modal-xl');
    }

    if (settings.always_close)
        footer_ok.attr('data-dismiss', 'modal');
    if (!settings.show_header)
        modal.find('.modal-header').remove();
    if (!settings.show_footer)
        modal.find('.modal-footer').remove();

    if(settings.close_outsid){
        modal.attr('data-bs-keyboard',false);
        modal.attr('data-bs-backdrop','static');
    }


    footer_ok.on('click', function () {
        settings.onOk(modal, loader_, modal_sucess, modal_error)
    });
    footer_cancel.on('click', settings.onCancel);


    jQuery.get(url, settings.post_data, function (data) {
        if (settings.footer_ok) footer_ok.html(settings.ok).appendTo(modal.find('.modal-footer'));
        if (settings.footer_cancel) footer_cancel.html(settings.cancel).appendTo(modal.find('.modal-footer'));
        if (settings.header_close) header_close.appendTo(modal.find('.modal-header'));

        modal.find('.modal-title').html(settings.title);
        modal.find('.modal-body').html(data);
        settings.onLoad(data, modal);


    }).fail(function () {
        modal.find('.modal-body').append(modal_error);
        footer_cancel.html('FERMER').appendTo(modal.find('.modal-footer'));
    });

    jQuery('body').css({
        'height': jQuery(window).height(),
        'overflow': 'hidden !important'
    });
    settings.context = modal;


    jQuery('.page-wrapper').css('filter', 'blur(1px)');

    return modal
        .attr('id', id)
        .appendTo('body')
        .modal('show')
        .on('hidden.bs.modal', function (e) {
            jQuery('.page-wrapper').css('filter', 'unset')
            settings.onClose(e);
            jQuery(this).remove();
            jQuery('body').css({
                'height': 'auto',
                'overflow': ''
            });
        })
        .find('.modal-body')
        .append(loader_)


};

var run_waitMe=function (el, num, effect) {
    text = '';
    fontSize = '';
    switch (num) {
        case 1:
            maxSize = '';
            textPos = 'vertical';
            break;
        case 2:
            text = '';
            maxSize = 30;
            textPos = 'vertical';
            break;
        case 3:
            maxSize = 30;
            textPos = 'horizontal';
            fontSize = '18px';
            break;
    }
    el.waitMe({
        effect: effect,
        text: text,
        bg: 'rgba(255,255,255,0.7)',
        color: '#1bb1e7',
        maxSize: maxSize,
        waitTime: -1,
        source: 'img.svg',
        textPos: textPos,
        fontSize: fontSize,
        onClose: function(el) {}
    });
};

$(document).on('click', '[data-action]', function () {
    $(document).trigger(this.dataset.action, {element : $(this)});
})
