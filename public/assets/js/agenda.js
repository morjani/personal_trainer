! function(g) {
    let page = $('#page_agenda');
    if(page.length ===0) return false;

    $(document).ready(function () {
        let hash_agenda = window.location.hash;

        if(hash_agenda){
            let value_hash = hash_agenda.replace('#', '');
            $(value_hash).trigger('click');
        }

        $('#event-date-start, #event-date-end').datepicker({
            format : "yyyy-mm-dd",
            container: '#event-modal'
        });

    })
        .on('edit_event_category',function (elem,data) {

            let id = data.element.data('id');
            editEventCategory(id);
        });

    let editEventCategory=function (id) {

        modalAjax('/agenda/edit-event-category/'+id, {

            title           : 'Modifier Catégorie' ,
            header_close    : true,
            footer_ok       : true,
            footer_cancel   : true,
            very_small      : false,
            size_md         : true,
            size_lg         : false,
            close_outsid    : true,
            ok              : 'Enregistrer',
            cancel          : 'Annuler',
            error_msg       : 'error',
            sucess_msg      : 'Données enregistrées avec succès!',
            always_close    : false,
            show_header     : true,
            show_footer     : true,
            post_data       : {},
            onLoad          : function(){

                $("#form_event_category").validate({
                    rules: {
                        name:  {
                            required:true
                        },
                    },

                });

            },
            onOk            : function (modal, loader, sucess, fail){

                let form =$('#form_event_category');


                if(form.valid()){

                    let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                    $('.modal-footer button').attr('disabled',true);
                    $('#modal_dialog_ok').html(i_load+"Enregister");

                    $.post('/api/ajax/update-event-category',form.serialize()+'&id='+id,function (res) {

                        if(res.status === 'SUCCESS'){
                            modal.modal('hide');
                            location.reload();
                        }
                        else{
                            Swal.fire(res.message,'','error');
                            $('.modal-footer button').attr('disabled',false);
                            $('#modal_dialog_ok').html("Enregister");

                        }

                    },'json');


                }

            },
            onCancel        : function () {},
            onClose         : function () {}
        });
    };

    "use strict";

    function e() {}

    e.prototype.init = function() {
        var l = g("#event-modal"),
            t = g("#modal-title"),
            a = g("#form-event"),
            i = null,
            r = null,
            s = document.getElementsByClassName("needs-validation"),
            i = null,
            r = null,
            e = new Date,
            n = e.getDate(),
            d = e.getMonth(),
            o = e.getFullYear();
        // new FullCalendarInteraction.Draggable(document.getElementById("external-events"), {
        //     itemSelector: ".external-event",
        //     eventData: function(e) {
        //
        //         return {
        //             title: e.innerText,
        //             className: g(e).data("class")
        //         }
        //     }
        // });
        var c = events,
            v = (document.getElementById("external-events"), document.getElementById("calendar"));

        function u(e) {
            l.modal("show"),
                a.removeClass("was-validated"),
                a[0].reset(),
                g("#event-title").val(),
                g("#event-category").val(),
                g("#event-description").val(),
                t.text("Add Event"),
                r = e

            $('#event-date-start').val(moment(e.date).format('YYYY-MM-DD'));
        }
        var m = new FullCalendar.Calendar(v, {
            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
            locale: 'fr',
            editable: false,
            droppable: false,
            selectable: !0,
            defaultView: "dayGridMonth",
            themeSystem: "bootstrap",
            buttonText: {
                today: "Aujourd'hui",
                day: 'Jour',
                week:'Semaine',
                month:'Mois'
            },
            header: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            // monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'September', 'October', 'November', 'Décember'],
            // dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            // dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            // dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            eventClick: function(e) {

                    a[0].reset(),
                    i = e.event,

                $.get('/api/ajax/get-event/'+i.id,function (res) {

                    g("#event-title").val(i.title),
                    g("#event-category").val(i.classNames[0]),
                    g("#event-id").val(i.id),
                    g("#event-date-start").val(moment(i.start).format('YYYY-MM-DD')),
                    g("#event-date-end").val(moment(i.end).format('YYYY-MM-DD')),
                    g("#event-description").val(res.result.description),
                    r = e,
                    t.text("Edit Event"),
                    r = e;

                },'json');

                l.modal("show");


            },
            dateClick: function(e) {
                g("#event-id").val('');
                u(e);
            },
            events: c
        });
        m.render(), g(a).on("submit", function(e) {
            e.preventDefault();
            g("#form-event :input");
            var t, a = g("#event-title").val(),
                n = g("#event-category").val();

            if(!1 === s[0].checkValidity()){

                (event.preventDefault(), event.stopPropagation(), s[0].classList.add("was-validated"));

            }
            else
            {
                let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                $('#form-event button').attr('disabled',true);
                $('#btn-save-event').html(i_load+"Enregister");

                run_waitMe($('#calendar'), 1,'roundBounce');

                $.post('/api/ajax/save-event',
                    {
                        'event_id' : $('#event-id').val(),
                        'title' : a,
                        'start' : $('#event-date-start').val(),
                        'end' :  $('#event-date-end').val(),
                        'class_name' : n,
                        'description' : $('#event-description').val(),
                    },function (res) {

                    if(res.status ===  'SUCCESS')
                    {
                        (i ? (i.setProp("title", a), i.setProp("classNames", [n])) : (t = {
                            id: res.result.id,
                            title: a,
                            start: r.date,
                            end: $('#event-date-end').val(),
                            description: $('#event-description').val(),
                            allDay: r.allDay,
                            className: n
                        }, m.addEvent(t)), l.modal("hide"))

                        location.reload();
                    }
                    else
                        Swal.fire(res.message,'','error');

                },'json').always(function () {
                    setTimeout(function () {

                        $('#form-event button').attr('disabled',false);
                        $('#btn-save-event').html("Enregister");

                        $("#calendar").waitMe('hide');

                    },800);

                });

            }

            // !1 === s[0].checkValidity() ?
            //     (event.preventDefault(), event.stopPropagation(), s[0].classList.add("was-validated")) :
            //     (i ? (i.setProp("title", a), i.setProp("classNames", [n])) : (t = {
            //     title: a,
            //     start: r.date,
            //     allDay: r.allDay,
            //     className: n
            // }, m.addEvent(t)), l.modal("hide"))
        }), g("#btn-delete-event").on("click", function(e) {

            let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
            $('#form-event button').attr('disabled',true);
            $('#btn-save-event').html(i_load+"Enregister");

            run_waitMe($('#calendar'), 1,'roundBounce');

            $.post('/api/ajax/delete-event',{'event_id' : $('#event-id').val()},function (res) {

                if(res.status === 'SUCCESS'){

                    i && (i.remove(), i = null, l.modal("hide"))

                }
                else
                    Swal.fire(res.message,'','error');

            },'json').always(function () {
                setTimeout(function () {

                    $('#form-event button').attr('disabled',false);
                    $('#btn-save-event').html("Enregister");

                    $("#calendar").waitMe('hide');

                },800);

            });


        }), g("#btn-new-event").on("click", function(e) {

            g("#event-id").val('');

            u({
                date: new Date,
                allDay: 1
            })
        })
    }, g.CalendarPage = new e, g.CalendarPage.Constructor = e
}(window.jQuery),
    function() {
        let page = $('#page_agenda');
        if(page.length ===0) return false;

        "use strict";
        window.jQuery.CalendarPage.init();
    }();
