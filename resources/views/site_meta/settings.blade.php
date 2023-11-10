<div class="container-fluid" id="page_settings">
    <form id="form_setting">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h5 class="fw-semibold">Configuration</h5>
                    </div>
                    <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="bill_information_compl">Facture information complementaire</label>
                                        <textarea id="bill_information_compl" name="bill_information_compl" class="form-control">{{ $bill_information_compl ?: '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="bill_information_verychic">Facture information verychic</label>
                                        <textarea id="bill_information_verychic" name="bill_information_verychic">{{ $bill_information_verychic ?: '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="logo_site">Logo site</label>
                                        <input type="file" id="logo_site" name="logo_site" class="dropify" data-default-file="{{ $logo_site ?: '' }}"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="logo_bill">Logo facture</label>
                                        <input type="file" id="logo_bill" name="logo_bill" class="dropify" data-default-file="{{ $logo_bill ?: '' }}"/>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" style="text-align: right;">
                <a href="{{ route('bills') }}" type="button" class="btn btn-danger waves-effect waves-light">
                    <i class="fas fa-caret-left"></i> Annuler
                </a>
                <button type="button" id="save_setting" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-save"></i> Enregister
                </button>
            </div>
        </div>
    </form>

</div>


