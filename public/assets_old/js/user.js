$(function () {

    let page = $('#page_user');

    if(page.length ===0 ) return false;

    $(document).ready(function () {


        table= initDatatable('#table_user', [
            {
                title : 'Photo',
                name  : 'image',
                data  : 'image',
                render: null,
                orderable : false,
                searchable : false,
            },
            {
                title : 'Nom',
                name  : 'fullname',
                data  : 'fullname',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : 'Nom d\'utilisateurs',
                name  : 'name',
                data  : 'name',
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
            ajax    : "/user/dt-user",
            order           : [[4, 'desc']],
        }, undefined);


    })
});

