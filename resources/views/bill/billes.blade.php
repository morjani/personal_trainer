<div class="container-fluid" id="page_bill">
    <div class="row">
        <div class="col-lg-12">

            <div class="gc_navigate">
                <ul>
                    <li class="active">
                        <a href="#suivi">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#canceled">
                            <i class="fa fa-tag"></i>
                            <span>Annuler</span>
                            <b data-stats="canceled_current">0</b>
                        </a>
                    </li>
                    <li>
                        <a href="#proforma">
                            <i class="fa fa-tag"></i>
                            <span>Proforma</span>
                            <b data-stats="proforma_current">0</b>
                        </a>
                    </li>
                    <li>
                        <a href="#bills">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Factures</span>
                            <b data-stats="bill_current">0</b>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card mt-4">
                <div class="tab-content p-3" id="content_bills" style="min-height: 200px">
                    <div class="tab-pane active" id="suivi" role="tabpanel" style="min-height: 200px">

                    </div>
                    <div class="tab-pane" id="canceled" role="tabpanel">
                        <div class="card-body mt-2">
                            <div class="table-responsive">
                                <table id="table_canceled" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>Réference</th>
                                        <th>Numéro</th>
                                        <th>Client</th>
                                        <th>Utilisateur</th>
                                        <th>Total TTC</th>
                                        <th>Date création</th>
                                        <th>Date modifiction</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="proforma" role="tabpanel">
                        <div class="card-body border-bottom">
                            <a href="{{ route('new-bill') }}" type="button" class="btn btn-outline-info waves-effect waves-light" style="float: right;">
                                <i class="fa fa-plus"></i> Nouvelle proforma
                            </a>
                        </div>
                        <div class="card-body mt-2">
                            <div class="table-responsive">
                                <table id="table_proforma" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>Réference</th>
                                        <th>Client</th>
                                        <th>Utilisateur</th>
                                        <th>Total TTC</th>
                                        <th>Date création</th>
                                        <th>Date modifiction</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bills" role="tabpanel">
                        <div class="card-body mt-2">
                            <div class="table-responsive">
                                <table id="table_bill" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>Réference</th>
                                        <th>Numéro</th>
                                        <th>Client</th>
                                        <th>Utilisateur</th>
                                        <th>Total TTC</th>
                                        <th>Date création</th>
                                        <th>Date modifiction</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


