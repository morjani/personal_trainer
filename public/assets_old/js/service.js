$(function () {

    let page = $('#page_category');

    if(page.length ===0 ) return false;

    $(document).ready(function () {


        table = initDatatable('#table_category', [
            {
                title : 'Catégorie',
                name  : 'name',
                data  : 'name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Description",
                name  : 'description',
                data  : 'description',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Date création",
                name  : 'created_at',
                data  : 'created_at',
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
            ajax    : "/service/dt-category",
            order           : [[2, 'desc']],
        }, undefined);

    })
        .on('new_category',function (elem,data) {

            newCategory();

        })
        .on('edit_category',function (elem,data) {

            let category_id = data.element.data('id');
            newCategory(category_id);

        })
        .on('delete_category',function (elem,data) {

        let category_id = data.element.data("id"),
            that = $(this);

        Swal.fire({
            title: 'Voulez-vous vraiment confirmer cette catégorie ?',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            denyButtonText: 'Non',
        }).then((result) => {
            if (result.isConfirmed) {

                $.post('/api/ajax/delete-category',{'category_id' : category_id},function (res) {

                    if(res.status === 'SUCCESS'){

                        Swal.fire(res.message,'','success');
                        table.ajax.reload();

                    }
                    else
                        Swal.fire(res.message,'','error');


                },'json');

            }
        });

    });

    let newCategory=function (category_id='') {

        modalAjax('/service/new-category/'+category_id, {

            title           : category_id === '' ? 'Nouvelle catégorie' : 'Modifier catégorie' ,
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




                $("#form_category").validate({
                    rules: {
                        name:  {
                            required:true
                        }
                    },

                });

            },
            onOk            : function (modal, loader, sucess, fail){

                let form =$('#form_category');

                if(form.valid()){

                    let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                    $('.modal-footer button').attr('disabled',true);
                    $('#modal_dialog_ok').html(i_load+"Enregister");

                    $.post('/api/ajax/save-category',form.serialize()+'&category_id='+category_id,function (res) {

                        if(res.status==="SUCCESS")
                        {
                            modal.modal('hide');
                            table.ajax.reload();
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

});

//Page service

$(function () {

    let page = $('#page_service');

    if(page.length ===0 ) return false;

    $(document).ready(function () {


        table = initDatatable('#table_service', [
            {
                title : 'Service',
                name  : 'name',
                data  : 'name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : 'Catégorie',
                name  : 'category_name',
                data  : 'category_name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Description",
                name  : 'description',
                data  : 'description',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Date création",
                name  : 'created_at',
                data  : 'created_at',
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
            ajax    : "/service/dt-service",
            order           : [[3, 'desc']],
        }, undefined);

    })
        .on('new_service',function (elem,data) {

            newService();

        })
        .on('edit_service',function (elem,data) {

            let service_id = data.element.data('id');
            newService(service_id);

        })
        .on('delete_service',function (elem,data) {

            let service_id = data.element.data("id"),
                that = $(this);

            Swal.fire({
                title: 'Voulez-vous vraiment suppirmer cette service ?',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                denyButtonText: 'Non',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post('/api/ajax/delete-service',{'service_id' : service_id},function (res) {

                        if(res.status === 'SUCCESS'){

                            Swal.fire(res.message,'','success');
                            table.ajax.reload();

                        }
                        else
                            Swal.fire(res.message,'','error');


                    },'json');

                }
            });

        });

    let newService=function (service_id='') {

        modalAjax('/service/new-service/'+service_id, {

            title           : service_id === '' ? 'Nouveau service' : 'Modifier service' ,
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

                $('#service_category').select2({
                    dropdownParent: $(".modal")
                });

                $("#form_service").validate({
                    rules: {
                        name:  {
                            required:true
                        },
                        price:  {
                            required:true,
                            number:true
                        }
                    },

                });

            },
            onOk            : function (modal, loader, sucess, fail){

                let form =$('#form_service');

                if(form.valid()){

                    let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                    $('.modal-footer button').attr('disabled',true);
                    $('#modal_dialog_ok').html(i_load+"Enregister");

                    $.post('/api/ajax/save-service',form.serialize()+'&service_id='+service_id,function (res) {

                        if(res.status==="SUCCESS")
                        {
                            modal.modal('hide');
                            table.ajax.reload();
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



});

