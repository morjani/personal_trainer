$(function () {

    let page = $('#page_customer');

    if(page.length ===0 ) return false;

    $(document).ready(function () {


        table_customer = initDatatable('#table_customer', [
            {
                title : 'Client',
                name  : 'last_name',
                data  : 'last_name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : 'ICE',
                name  : 'ice',
                data  : 'ice',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Ville",
                name  : 'city_name',
                data  : 'city_name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Téléphone",
                name  : 'phone',
                data  : 'phone',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Email",
                name  : 'email',
                data  : 'email',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Date modifiction",
                name  : 'updated_at',
                data  : 'updated_at',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Actions",
                name  : 'actions',
                data  : 'actions',
                render: null,
                orderable : false,
                searchable : false,
            },
        ], {
            ajax    : "/customer/dt-customer",
            order           : [[5, 'desc']],
        }, undefined);

        table_prospect = initDatatable('#table_prospect', [
            {
                title : 'Prospect',
                name  : 'last_name',
                data  : 'last_name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : 'ICE',
                name  : 'ice',
                data  : 'ice',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Ville",
                name  : 'city_name',
                data  : 'city_name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Téléphone",
                name  : 'phone',
                data  : 'phone',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Email",
                name  : 'email',
                data  : 'email',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Date modifiction",
                name  : 'updated_at',
                data  : 'updated_at',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Actions",
                name  : 'actions',
                data  : 'actions',
                render: null,
                orderable : false,
                searchable : false,
            },
        ], {
            ajax    : "/customer/dt-prospect",
            order           : [[5, 'desc']],
        }, undefined);

    })
        .on('new_customer',function (elem,data) {

            let prospect = data.element.data('prospect');
            newCustomer('',prospect);

        })
        .on('edit_customer',function (elem,data) {

            let customer_id = data.element.data('id');
            newCustomer(customer_id);

        })
        .on('delete_customer',function (elem,data) {

        let customer_id = data.element.data("id"),
            that = $(this);

        Swal.fire({
            title: 'Voulez-vous vraiment confirmer cette client ?',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            denyButtonText: 'Non',
        }).then((result) => {
            if (result.isConfirmed) {

                $.post('/api/ajax/delete-customer',{'customer_id' : customer_id},function (res) {

                    if(res.status === 'SUCCESS'){

                        Swal.fire(res.message,'','success');
                        table_customer.ajax.reload();
                        table_prospect.ajax.reload();

                    }
                    else
                        swal.fire(res.message,'','error');


                },'json');

            }
        });

    });

    let newCustomer=function (customer_id= '',prospect = '') {

        modalAjax('/customer/new-customer/'+customer_id, {

            title           : customer_id === '' ? 'Nouveau client' : 'Modifier client' ,
            header_close    : true,
            footer_ok       : true,
            footer_cancel   : true,
            very_small      : false,
            size_md         : false,
            size_lg         : true,
            close_outsid    : true,
            ok              : 'Enregistrer',
            cancel          : 'Annuler',
            error_msg       : 'error',
            sucess_msg      : 'Données enregistrées avec succès!',
            always_close    : false,
            show_header     : true,
            show_footer     : true,
            post_data       : {prospect : prospect},
            onLoad          : function(){

                $('#file_upload').dropify();

                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove: 'Supprimer',
                        error: 'Désolé, le fichier trop volumineux'
                    }
                });

                $('.dropify-message').find('p').first().hide();

                $('#customer_city').select2({
                    minimumInputLength: 2,
                    dropdownParent: $(".modal"),
                    tags: [],
                    ajax: {
                        url: '/api/ajax/search-city',
                        dataType: 'json',
                        type: "GET",
                        quietMillis: 50,
                        data: function (term) {
                            return {
                                term: term,
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: !0
                    }
                });


                $("#form_customer").validate({
                    rules: {
                        first_name:  {
                            required:true
                        },
                        // last_name:  {
                        //     required:true
                        // },
                        phone:  {
                            required:true
                        },
                        // email:  {
                        //     required:true
                        // },
                        // ice:  {
                        //     required:true
                        // },
                    },

                });

            },
            onOk            : function (modal, loader, sucess, fail){

                let form =$('#form_customer');

                let formData = new FormData(form[0]);

                if(form.valid()){

                    let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                    $('.modal-footer button').attr('disabled',true);
                    $('#modal_dialog_ok').html(i_load+"Enregister");

                    formData.append('customer_id', customer_id);

                    $.ajax({
                        url: '/api/ajax/save-customer',
                        type: 'POST',
                        data: formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (res) {

                            if(res.status==="SUCCESS")
                            {
                                modal.modal('hide');
                                table_customer.ajax.reload();
                                table_prospect.ajax.reload();
                            }
                            else{
                                Swal.fire(res.message,'','error');
                                $('.modal-footer button').attr('disabled',false);
                                $('#modal_dialog_ok').html("Enregister");

                            }

                        }
                    });

                }
            },
            onCancel        : function () {},
            onClose         : function () {}
        });
    };

});

