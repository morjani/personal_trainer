<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ce Mois</h4>

                        <div>
                            <div id="donut-chart" data-colors='["--bs-primary", "--bs-success", "--bs-danger"]' class="apex-charts"></div>
                        </div>

                        <div class="text-center text-muted">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i> Annuler</p>
                                        <h5>{{ $month['sum_canceled'].' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i> Proforma</p>
                                        <h5>{{ $month['sum_proforma'].' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Factures</p>
                                        <h5>{{ $month['sum_factures'].' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3 align-self-center">
                                        <i class="mdi mdi-book-cancel h2 text-warning mb-0"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-2">Annuler</p>
                                        <h5 class="mb-0">{{ $canceled_total.' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3 align-self-center">
                                        <i class="bx bx-receipt h2 text-primary mb-0"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-2">Proforma</p>
                                        <h5 class="mb-0">{{ $proforma_total.' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3 align-self-center">
                                        <i class="mdi mdi-shopping h2 text-info mb-0"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-2">Factures</p>
                                        <h5 class="mb-0">{{ $factures_total.' '. crmCurreny() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Aperçu</h4>

                        <div>
                            <div id="overview-bill" data-colors='["--bs-warning", "--bs-primary", "--bs-info"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let count_bills = <?php echo json_encode($count_bills)?>,
        percent_canceled=<?php echo $month['percentage_canceled'] ?>,
        percent_proforma=<?php echo $month['percentage_proforma'] ?>,
        percent_factures=<?php echo $month['percentage_factures'] ?>;
</script>
