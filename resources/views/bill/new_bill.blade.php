<div class="container-fluid" id="page_new_bill">
    <form id="form_bill" enctype="multipart/form-data">
<div class="hidden">
    <input type="hidden" id="bill_id" value="{{ $bill ? $bill->id : ''  }}">
    <input type="hidden" id="bill_state" value="{{ $bill ? $bill->state : ''  }}">
</div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h5 class="fw-semibold">Nouvelle proforma</h5>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="bill_customer">Client</label>
                                        <select name="customer_id" id="bill_customer" class="form-control">
                                            <option selected disabled value="">Sélectionner</option>
                                            @if($bill and $customer)
                                                <option value="{{ $customer->id }}" selected>{{ $customer->first_name.' '.$customer->last_name }}</option>
                                            @endif
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="bill_date">Date</label>
                                        <input type="text" name="date" id="bill_date" class="form-control" value="{{ $bill ? date('Y-m-d',strtotime($bill->date)) : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="bill_payment_method">Moyenne de paiement</label>
                                        <select name="payment_method" id="bill_payment_method" class="form-control">
                                            <option selected disabled value="">Sélectionner</option>
                                            <option {{ ($bill and $bill->payment_method == 'espece') ? 'selected' :  ''  }} value="espece">
                                                Espéce
                                            </option>
                                            <option {{ ($bill and $bill->payment_method == 'carte') ? 'selected' :  ''  }} value="carte">
                                                Carte
                                            </option>
                                            <option {{ ($bill and $bill->payment_method == 'virement') ? 'selected' :  ''  }} value="virement">
                                                Virement
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="bill_description">Description</label>
                                        <textarea name="description" id="bill_description" class="form-control">{{ $bill ? $bill->description : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="event_date">Date d'activité</label>
                                        <input type="text" name="event_date" id="event_date" class="form-control"
                                               value="{{ $bill && $bill->event_date ? date('Y-m-d',strtotime($bill->event_date)) : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="event_title">Titre activité</label>
                                        <input type="text" name="event_title" id="event_title" class="form-control"
                                               value="{{ $event_title }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="bill_additional_information">Information complémentaire</label>
                                        <textarea name="additional_information" id="bill_additional_information" class="form-control" rows="3">{{ $bill ? $bill->additional_information : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="list_services" style="min-height: 200px">
            <div class="col-sm-12">
                <button type="button" data-action="new_bill_service" class="btn btn-soft-primary waves-effect waves-light"
                        style="float: right;">
                    <i class="fa fa-plus"></i> Nouveau service
                </button>
            </div>
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                            <tr>
                                <th scope="col">Service</th>
                                <th scope="col">Unité</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody class="content_services">
                            <tr>
                                <td colspan="5" class="text-center">Aucun donner</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12" style="text-align: right;">
                <a href="{{ route('new-bill') }}" type="button" class="btn btn-danger waves-effect waves-light">
                    <i class="fas fa-caret-left"></i> Annuler
                </a>
                <button type="submit" id="save_bill" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-save"></i> Enregister
                </button>
            </div>
        </div>

    </form>
</div>

<script>
let data_details = <?php echo json_encode($data_details , JSON_FORCE_OBJECT) ?>;
</script>


