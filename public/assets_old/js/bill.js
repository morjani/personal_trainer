$(function () {

    let page = $('#page_bill');

    if(page.length ===0 ) return false;

    $(document).ready(function () {

        billStatic();
        billSuivi();

        let hash_bill = window.location.hash;

        if(hash_bill){

            $('.gc_navigate a').each(function () {
                if($(this).attr('href') === hash_bill){

                    $(this).trigger('click');
                    // $('[data-hash="'+hash_bill+'"]').addClass('active').closest('li').addClass('mm-active').closest('ul').addClass('mm-show');

                }

            });
        }

        table_canceled = initDatatable('#table_canceled', [
            {
                title : 'Réference',
                name  : 'reference',
                data  : 'reference',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Numéro",
                name  : 'number',
                data  : 'number',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Client",
                name  : 'customer',
                data  : 'customer',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Utilisateur",
                name  : 'name',
                data  : 'name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Total TTC",
                name  : 'total_ttc',
                data  : 'total_ttc',
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
            ajax    : "/bill/dt-canceled",
            order           : [[5, 'desc']],
        }, undefined);


        table_proforma = initDatatable('#table_proforma', [
            {
                title : 'Réference',
                name  : 'reference',
                data  : 'reference',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Client",
                name  : 'customer',
                data  : 'customer',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Utilisateur",
                name  : 'name',
                data  : 'name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Total TTC",
                name  : 'total_ttc',
                data  : 'total_ttc',
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
            ajax    : "/bill/dt-proforma",
            order           : [[4, 'desc']],
        }, undefined);

        table_bill = initDatatable('#table_bill', [
            {
                title : 'Réference',
                name  : 'reference',
                data  : 'reference',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Numéro",
                name  : 'number',
                data  : 'number',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Client",
                name  : 'customer',
                data  : 'customer',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Utilisateur",
                name  : 'name',
                data  : 'name',
                render: null,
                orderable : true,
                searchable : true,
            },
            {
                title : "Total TTC",
                name  : 'total_ttc',
                data  : 'total_ttc',
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
            ajax    : "/bill/dt-bill",
            order           : [[5, 'desc']],
        }, undefined);

    })
        .on('click','.gc_navigate a',function () {

            run_waitMe($('#content_bills'), 1,'roundBounce');

            let id = $(this).attr('href');

            $('.gc_navigate li').removeClass('active');
            $(this).closest('li').addClass('active');
            $('.tab-pane').removeClass('active');
            $(id).addClass('active');

            setTimeout(function () {
                $('#content_bills').waitMe('hide');
            },800);
        })
        .on('valid_proforma',function (elem,data) {

            let bill_id = data.element.data("id"),
                that = $(this);

            Swal.fire({
                title: 'Voulez-vous vraiment valider cette proforma ?',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                denyButtonText: 'Non',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post('/api/ajax/valid-proforma',{'bill_id' : bill_id},function (res) {

                        if(res.status === 'SUCCESS'){

                            Swal.fire(res.message,'','success');
                            table_proforma.ajax.reload();
                            table_bill.ajax.reload();
                            billStatic();
                            billSuivi();

                        }
                        else
                            Swal.fire(res.message,'','error');


                    },'json');

                }
            });

        })
        .on('detail_bill',function (elem,data) {

            let bill_id = data.element.data("id"),
                that = $(this);

            detailBill(bill_id);

        })
        .on('canceled_bill',function (elem,data) {

            let bill_id = data.element.data("id"),
                that = $(this);

            Swal.fire({
                title: 'Voulez-vous vraiment annuler cette facture ?',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                denyButtonText: 'Non',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post('/api/ajax/canceled-bill',{'bill_id' : bill_id},function (res) {

                        if(res.status === 'SUCCESS'){

                            Swal.fire(res.message,'','success');
                            table_proforma.ajax.reload();
                            table_bill.ajax.reload();
                            billStatic();
                            billSuivi();

                        }
                        else
                            Swal.fire(res.message,'','error');


                    },'json');

                }
            });

        })
        .on('delete_bill',function (elem,data) {

            let bill_id = data.element.data("id"),
                that = $(this);

            Swal.fire({
                title: 'Voulez-vous vraiment supprimer cette facture ?',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                denyButtonText: 'Non',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post('/api/ajax/delete-bill',{'bill_id' : bill_id},function (res) {

                        if(res.status === 'SUCCESS'){

                            Swal.fire(res.message,'','success');
                            table_proforma.ajax.reload();
                            table_bill.ajax.reload();
                            table_canceled.ajax.reload();
                            billStatic();
                            billSuivi();

                        }
                        else
                            Swal.fire(res.message,'','error');


                    },'json');

                }
            });

        });


    function billStatic(){

       run_waitMe($('.gc_navigate'), 3,'bouncePulse');

        $.get('/api/ajax/bill-statis',function (res) {

                $('[data-stats="canceled_current"]').text(res.total_canceled);
                $('[data-stats="proforma_current"]').text(res.total_proforma);
                $('[data-stats="bill_current"]').text(res.total_bill);
                $('#suivi').html(res.view_suivi);

        },'json').always(function () {
            setTimeout(function () {

                $(".gc_navigate").waitMe('hide');

            },800);

        });

    }

    function billSuivi(){

        run_waitMe($('#suivi'), 1,'roundBounce');

        $.get('/api/ajax/bill-suivi',function (res) {

            $('#suivi').html(res);

            var options, chartOverview, overviewChartColors = getChartColorsArray("overview-bill");
            overviewChartColors && (options = {
                series: [{
                    type: "area",
                    name: "Annuler",
                    data: count_bills.canceled
                }, {
                    type: "area",
                    name: "Proforma",
                    data: count_bills.proforma
                }, {
                    type: "line",
                    name: "Factues",
                    data: count_bills.factures
                }],
                chart: {
                    height: 240,
                    type: "line",
                    toolbar: {
                        show: !1
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    curve: "smooth",
                    width: 2,
                    dashArray: [0, 0, 3]
                },
                fill: {
                    type: "solid",
                    opacity: [.15, .05, 1]
                },
                xaxis: {
                    categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aôu", "Sép", "Oct", "Nov", "Déc"]
                },
                colors: overviewChartColors
            }, (chartOverview = new ApexCharts(document.querySelector("#overview-bill"), options)).render());

            var options, chart, donutchartColors = getChartColorsArray("donut-chart");
            donutchartColors && (options = {
                series: [percent_canceled,percent_proforma,percent_factures],
                chart: {
                    type: "donut",
                    height: 262
                },
                labels: ["Annuler", "Proforma", "Factures"],
                colors: ["#df1c44","#194a8d","#39a275"],
                fill: {
                    type: 'gradient',
                },
                legend: {
                    show: !1
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "70%"
                        }
                    }
                }
            }, (chart = new ApexCharts(document.querySelector("#donut-chart"), options)).render());

        }).always(function () {
            setTimeout(function () {

                $("#suivi").waitMe('hide');

            },800);

        });

    }

    let detailBill=function (bill_id) {

        modalAjax('/bill/detail-bill/'+bill_id, {

            title           : 'Détails' ,
            header_close    : true,
            footer_ok       : false,
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
            show_header     : false,
            show_footer     : true,
            post_data       : {},
            onLoad          : function(){

                $('#print_bill').on('click',function () {


                    var divContents = document.getElementById('download_section').innerHTML;

                    var header=$('head').html();
                    header+='<link rel="stylesheet" href="/assets/invoice/css/style.css">';

                    var printWindow = window.open('', '', '');
                    printWindow.document.write('<html><head>'+header);
                    printWindow.document.write('</head><body >');
                    printWindow.document.write(divContents);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();

                    setTimeout(function() {
                        printWindow.print();
                        printWindow.close();

                    }, 800);

                });

                // $('#download_btn').on('click', function () {
                //     var downloadSection = $('#download_section');
                //     var cWidth = downloadSection.width();
                //     var cHeight = downloadSection.height();
                //     var topLeftMargin = 40;
                //     var pdfWidth = cWidth + topLeftMargin * 2;
                //     var pdfHeight = pdfWidth * 1.5 + topLeftMargin * 2;
                //     var canvasImageWidth = cWidth;
                //     var canvasImageHeight = cHeight;
                //     var totalPDFPages = Math.ceil(cHeight / pdfHeight) - 1;
                //     var fillName = this.dataset.name;
                //
                //     downloadSection.closest('.modal-dialog').get(0).scrollIntoView();
                //
                //     html2canvas(downloadSection.get(0), { allowTaint: true }).then(function (
                //         canvas
                //     ) {
                //         canvas.getContext('2d');
                //         var imgData = canvas.toDataURL('image/png', 1.0);
                //         var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
                //         console.log(topLeftMargin);
                //         pdf.addImage(
                //             imgData,
                //             'png',
                //             topLeftMargin,
                //             topLeftMargin,
                //             canvasImageWidth,
                //             canvasImageHeight
                //         );
                //         for (var i = 1; i <= totalPDFPages; i++) {
                //             pdf.addPage(pdfWidth, pdfHeight);
                //             pdf.addImage(
                //                 imgData,
                //                 'png',
                //                 topLeftMargin,
                //                 -(pdfHeight * i) + topLeftMargin * 0,
                //                 canvasImageWidth,
                //                 canvasImageHeight
                //             );
                //         }
                //         pdf.save(fillName+'.pdf');
                //     });
                // });

            },
            onOk            : function (modal, loader, sucess, fail){

            },
            onCancel        : function () {},
            onClose         : function () {}
        });
    };


    function radialChart(element,colors,size){

        var options = {
            series: [37],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: {
                    enabled: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            colors: colors,
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: size
                    },
                    track: {
                        margin: 0
                    },
                    dataLabels: {
                        show: !1
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector(element), options);
        chart.render();

    }

});

$(function () {

   let page = $('#page_new_bill');

   if(page.length ===0) return false;

    let data_services = [],
        total_ht = 0,
        total_ttc = 0;

   $(document).ready(function () {

       $('#bill_date, #event_date').datepicker({
           format : "yyyy-mm-dd"
       });

       $('#bill_payment_method').select2();

       $('#bill_customer').select2({
           minimumInputLength: 2,
           tags: [],
           ajax: {
               url: '/api/ajax/search-customer',
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
                               text: item.last_name,
                               id: item.id
                           }
                       })
                   };
               },
               cache: !0
           }
       });

       $("#form_bill").validate({
           rules: {
               customer_id:  {
                   required:true
               },
               date:  {
                   required:true
               },
               payment_method:  {
                   required:true
               }
           },

       });

       if(data_details){

           $.each(data_details,function () {
               data_services.push(this);
           });

           loadServices(data_services);
       }

   })
       .on('click','#save_bill',function (e) {

           e.preventDefault();

           let form = $("#form_bill");

           if(form.valid()){

               run_waitMe($('#page_new_bill'), 1,'roundBounce');

               $.post('/api/ajax/save-bill',
                   {
                       'bill_id':$('#bill_id').val(),
                       'state':$('#bill_state').val(),
                       'services':data_services,
                       'customer_id' : $('#bill_customer').val(),
                       'date' : $('#bill_date').val(),
                       'event_date' : $('#event_date').val(),
                       'event_title' : $('#event_title').val(),
                       'payment_method' : $('#bill_payment_method').val(),
                       'description' : $('#bill_description').val(),
                       'total_ht' : total_ht.toFixed(2),
                       'total_ttc' : total_ttc.toFixed(2)
                   }
               ,function (res) {

                   if(res.status==="SUCCESS")
                   {
                       window.location.href = '/bills'
                   }
                   else{
                       Swal.fire(res.message,'','error');
                   }

               },'json').always(function () {
                   $('#page_new_bill').waitMe('hide');
               },800);

           }


       })
       .on('new_bill_service',function (elem,data) {

           newBillService();

       })
       .on('edit_bill_service',function (elem,data) {

           let id = data.element.data('id');
           newBillService(id);

       })
       .on('delete_bill_service',function (elem,data) {

           let id = data.element.data('id');
           deleteService(id);

       });

   function findService(id)
   {
       let find = null;

       $.each(data_services,function () {

           if(id === this.service.id)
               find = this;

       });

       return find;
   }

   function pushService(service,id=null)
   {
       let find = false;

       $.each(data_services,function () {

           if(service.service.id === this.service.id){

               if(id){
                   this.qty=service.qty;
                   this.total=service.total;
                   this.description=service.description;
                   this.with_tva=service.with_tva;
                   find = true;
               }
               else {
                   this.qty+=service.qty;
                   this.total+=service.total;
                   find = true;
               }

               return find;

           }

       });

       if(!find)
           data_services.push(service);

       loadServices(data_services);

   }
   function deleteService(id=null)
   {

       Swal.fire({
           title: 'Voulez-vous vraiment supprimer cette service ?',
           showCancelButton: true,
           confirmButtonText: 'Oui',
           denyButtonText: 'Non',
       }).then((result) => {
           if (result.isConfirmed) {

               $.each(data_services,function (item, queue) {

                   if(this.service.id === id){

                       data_services.splice(item, 1);
                       Swal.fire("Les données sont supprimé avec succès.",'','success');
                       loadServices(data_services);

                   }

               });

           }
       });


   }

   function loadServices(services)
   {

       let content_services = '',
           content_services_ = '',
           list_service = $('#list_services');

       run_waitMe(list_service, 1,'roundBounce');

       if(services.length > 0){

           total_ht = 0;
           total_ttc = 0;

           $.each(services,function () {

               if(this.with_tva === 1){

                   content_services+='<tr>'
                       +'<td>'
                       +'<h5 class="text-truncate font-size-14">'
                       +'<a href="javascript: void(0);" class="text-dark">'+this.service.name+'</a>'
                       +'</h5>'
                       +'<p class="text-muted mb-0">'+this.description+'</p>'
                       +'</td>'
                       +'<td>'+this.price+'</td>'
                       +'<td>'+this.qty+'</td>'
                       +'<td>'+this.total.toFixed(2)+'</td>'
                       +'<td><ul class="list-unstyled hstack gap-1 mb-0">'
                       +'<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">'
                       +'<a href="#" class="btn btn-sm btn-soft-info" data-action="edit_bill_service" data-id="'+this.service.id+'">'
                       +'<i class="mdi mdi-pencil-outline"></i>'
                       +'</a>'
                       +'</li>'
                       +'<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">'
                       +'<a href="#jobDelete" class="btn btn-sm btn-soft-danger" data-action="delete_bill_service" data-id="'+this.service.id+'">'
                       +'<i class="mdi mdi-delete-outline"></i>'
                       +'</a>'
                       +'</li>'
                       +'</ul>'
                       +'</td>'
                       +'</tr>';

                   total_ht+=this.total;

               }

               else
               {
                   content_services_+='<tr>'
                       +'<td>'
                       +'<h5 class="text-truncate font-size-14">'
                       +'<a href="javascript: void(0);" class="text-dark">'+this.service.name+'</a>'
                       +'</h5>'
                       +'<p class="text-muted mb-0">'+this.description+'</p>'
                       +'</td>'
                       +'<td>'+this.price+'</td>'
                       +'<td>'+this.qty+'</td>'
                       +'<td>'+this.total.toFixed(2)+'</td>'
                       +'<td><ul class="list-unstyled hstack gap-1 mb-0">'
                       +'<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">'
                       +'<a href="#" class="btn btn-sm btn-soft-info" data-action="edit_bill_service" data-id="'+this.service.id+'">'
                       +'<i class="mdi mdi-pencil-outline"></i>'
                       +'</a>'
                       +'</li>'
                       +'<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">'
                       +'<a href="#jobDelete" class="btn btn-sm btn-soft-danger" data-action="delete_bill_service" data-id="'+this.service.id+'">'
                       +'<i class="mdi mdi-delete-outline"></i>'
                       +'</a>'
                       +'</li>'
                       +'</ul>'
                       +'</td>'
                       +'</tr>';

                   total_ttc+=this.total;
               }

           });
           if(content_services!=='' || content_services_!==''){

               let content_total = '';

               if(total_ht){

                   total_ttc += (total_ht + total_ht * 20 / 100);

                   content_total='<tr>'
                       +'<th colspan="3" style="text-align: center">SOUS TOTAL</th>'
                       +'<td colspan="2">'+total_ht.toFixed(2)+'</td>'
                       +'</tr>'
                       +'<tr>'
                       +'<th colspan="3" style="text-align: center">TVA</th>'
                       +'<td colspan="2">20%</td>'
                       +'</tr>'
                       +content_services_
                       +'<tr>'
                       +'<th colspan="3" style="text-align: center">TOTAL TTC</th>'
                       +'<td colspan="2">'+total_ttc.toFixed(2)+'</td>'
                       +'</tr>';

                   content_services+=content_total;

                   $('.content_services').html(content_services);
               }


           }
       }
       else
       {
           content_services='<tr>'
               +'<td colspan="5" class="text-center">Aucun donner</td>'
               +'</tr>';

           $('.content_services').html(content_services);
       }



       setTimeout(function () {
           list_service.waitMe('hide');
       },800);

   }

    let newBillService=function (bill_service_id=null) {

        modalAjax('/bill/new-bill-service', {

            title           : bill_service_id  ? 'Modifier service' : 'Nouveau service' ,
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

                $("#bill_with_tva").select2({
                    dropdownParent: $(".modal"),
                    minimumResultsForSearch: Infinity
                });

                $('#bill_service_id').select2({
                    minimumInputLength: 2,
                    dropdownParent: $(".modal"),
                    tags: [],
                    ajax: {
                        url: '/api/ajax/search-service',
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
                })
                    .on('change',function () {

                        let service_id = $(this).val();

                        run_waitMe($('#form_bill_service'), 1,'roundBounce');

                        $.get('/api/ajax/get-service/'+service_id,function (res) {

                            $('#bill_service_price').val(res.price);

                        },'json').always(function () {

                            setTimeout(function () {
                                $('#form_bill_service').waitMe('hide');
                            },800);


                        });
                    });

                if(bill_service_id!==''){

                    let get_service = findService(bill_service_id);

                    if(get_service){

                        let service_option = '<option value="'+get_service.service.id+'" selected>'+get_service.service.name+'</option>'
                        $('#bill_service_id').append(service_option).attr('disabled',true);
                        $('#bill_service_description').val(get_service.description);
                        $('#bill_service_price').val(get_service.price);
                        $('#bill_service_qty').val(get_service.qty);
                        $('#bill_with_tva').val(get_service.with_tva).change();

                    }

                }

                $("#form_bill_service").validate({
                    rules: {
                        service_id:  {
                            required:true
                        },
                        price:  {
                            required:true,
                            number:true
                        },
                        quantity:  {
                            required:true,
                            number:true
                        },
                        description:  {
                            required:true
                        },
                    },

                });

            },
            onOk            : function (modal, loader, sucess, fail){

                let form =$('#form_bill_service');

                if(form.valid()){

                    let i_load = '<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>';
                    $('.modal-footer button').attr('disabled',true);
                    $('#modal_dialog_ok').html(i_load+"Enregister");

                    let price = parseFloat($('#bill_service_price').val()).toFixed(2),
                        qty = $('#bill_service_qty').val()*1;

                    let item = {
                        "service" : {
                            "id":$('#bill_service_id').val()*1,
                            "name":$("#bill_service_id option:selected").text()
                        },
                        "description" : $('#bill_service_description').val(),
                        "price" : price,
                        "qty" : qty,
                        "total" : price * qty,
                        "with_tva" : $('#bill_with_tva').val() * 1
                    };

                    pushService(item,bill_service_id);

                    modal.modal('hide');


                }
            },
            onCancel        : function () {},
            onClose         : function () {}
        });
    };

});




