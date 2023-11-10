$(document).ready(function () {
    $.validator.addMethod("pwcheck", function(value) {
        return /[A-Z]/.test(value) &&
            /\d/.test(value) &&
            /[=!\-@._*\$\#\%\^\&\(\)\~\`\<\>\/\?\\\|\{\}\[\]\;\:\'\"\,\+]/.test(value)
    }, "Veuillez saisir un mot de passe valide");
})
    .on('redirect_bill',function (elem,data) {

        let hash = data.element.data('hash');
        if(hash === 'bills' || hash ===  'proforma'){

            window.location = '/bills#'+hash;

            $('.gc_navigate a').each(function () {
                if($(this).attr('href') === '#'+hash){

                    $(this).trigger('click');

                }

            });
        }


    })

    .on('redirect_agenda',function (elem,data) {

        let hash = data.element.data('hash');

        if(hash === '.fc-timeGridDay-button' || hash ===  '.fc-timeGridWeek-button' || hash ===  '.fc-dayGridMonth-button'){

            window.location = '/agenda#'+hash;

            $(hash).trigger('click');

        }


    })

    .on('new_user',function (elem,data) {

        newUser();
    })

    .on('show_profile',function (elem,data) {

        let id = data.element.data('id');
        showProfile(id);
    })
    .on('change_password',function (elem,data) {

        let id = data.element.data('id');
        changePassword(id);
    });

let newUser=function () {

    modalAjax('/user/new-user/', {

        title           : 'Nouveau utilisateur' ,
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
        post_data       : {},
        onLoad          : function(){

            $('#profile_image').dropify();

            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            $('.dropify-message').find('p').first().hide();

            $("#form_user").validate({
                rules: {
                    first_name:  {
                        required:true
                    },
                    last_name:  {
                        required:true
                    },
                    email:  {
                        required:true,
                        email:true
                    },
                    name:  {
                        required:true
                    },
                    password:  {
                        required:true,
                        minlength:8,
                        pwcheck: "Veuillez saisir un mot de passe valide",
                    },
                    confirm_password:  {
                        required:true,
                        minlength:8,
                        equalTo : "#user_password"
                    }
                },

            });

        },
        onOk            : function (modal, loader, sucess, fail){

            let form =$('#form_user');

            let formData = new FormData(form[0]);

            if(form.valid()){

                let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                $('.modal-footer button').attr('disabled',true);
                $('#modal_dialog_ok').html(i_load+"Enregister");

                $.ajax({
                    url: '/api/ajax/save-user',
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
                            location.reload();
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

let showProfile=function (id) {

    modalAjax('/user/show-profile/'+id, {

        title           : 'Modifier profile' ,
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

            $('#profile_image').dropify();

            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            $('.dropify-message').find('p').first().hide();

            $("#form_profile").validate({
                rules: {
                    first_name:  {
                        required:true
                    },
                    last_name:  {
                        required:true
                    },
                    email:  {
                        required:true,
                        email:true
                    },
                    name:  {
                        required:true
                    }
                },

            });

        },
        onOk            : function (modal, loader, sucess, fail){

            let form =$('#form_profile');

            let formData = new FormData(form[0]);

            if(form.valid()){

                let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                $('.modal-footer button').attr('disabled',true);
                $('#modal_dialog_ok').html(i_load+"Enregister");

                formData.append('id', id);

                $.ajax({
                    url: '/api/ajax/save-profile',
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
                            location.reload();
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

let changePassword=function (id) {

    modalAjax('/user/change-password/'+id, {

        title           : 'Modifier le mot de passe' ,
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


            $("#form_password").validate({
                rules: {
                    current_password:  {
                        required:true,
                        minlength:8,
                        remote: {
                            url : "/api/ajax/check-password/"+id,
                            type : "post"
                        }
                    },
                    new_password:  {
                        required:true,
                        minlength:8,
                        pwcheck: "Das Passwort entspricht nicht den Kriterien!",
                    },
                    confirm_password:  {
                        required:true,
                        minlength:8,
                        equalTo : "#new_password"
                    }
                },

            });

        },
        onOk            : function (modal, loader, sucess, fail){

            let form =$('#form_password');

            if(form.valid()){

                if($('#new_password').val() === $('confirm_password').val()){



                }

                let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                $('.modal-footer button').attr('disabled',true);
                $('#modal_dialog_ok').html(i_load+"Enregister");

                $.post('/api/ajax/update-password',form.serialize()+'&id='+id,function (res) {

                    if(res.status==="SUCCESS")
                    {
                        modal.modal('hide');
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

