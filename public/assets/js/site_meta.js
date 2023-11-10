$(function () {
    let page = $("#page_settings");
    if(page.length===0) return false;

    $(document).ready(function () {

        0 < $("#bill_information_verychic").length && tinymce.init({
            selector: "textarea#bill_information_verychic",
            height: 300,
            plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [{
                title: "Bold text",
                inline: "b"
            }, {
                title: "Red text",
                inline: "span",
                styles: {
                    color: "#ff0000"
                }
            }, {
                title: "Red header",
                block: "h1",
                styles: {
                    color: "#ff0000"
                }
            }, {
                title: "Example 1",
                inline: "span",
                classes: "example1"
            }, {
                title: "Example 2",
                inline: "span",
                classes: "example2"
            }, {
                title: "Table styles"
            }, {
                title: "Table row 1",
                selector: "tr",
                classes: "tablerow1"
            }]
        })


        $('#logo_site').dropify();
        $('#logo_bill').dropify();

        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        $('.dropify-message').find('p').first().hide();
    })
        .on('click','#save_setting',function (e) {

            e.preventDefault();

            let form =$('#form_setting');

            let formData = new FormData(form[0]),
                bill_information_verychic = tinyMCE.editors[$('#bill_information_verychic').attr('id')].getContent();

            formData.set('bill_information_verychic',bill_information_verychic);

            run_waitMe(form, 1,'roundBounce');

            $.ajax({
                url: '/api/ajax/save-setting',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {

                    if(res.status==="SUCCESS")
                    {
                        location.reload();
                    }
                    else{
                        Swal.fire(res.message,'','error');

                    }

                }
            }).always(function () {
                $('#form_setting').waitMe('hide');
            },800);

        })
});
