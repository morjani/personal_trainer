<form id="form_bill_service" enctype="multipart/form-data">

    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="bill_service_id">Service</label>
                <select name="service_id" id="bill_service_id" class="form-control">
                    <option selected disabled value="">Sélectionner</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="bill_service_price">Unité</label>
                <input type="number" name="price" id="bill_service_price" class="form-control" disabled>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="bill_service_qty">Quantité</label>
                <input type="number" name="quantity" id="bill_service_qty" class="form-control">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="bill_with_tva">TVA</label>
                <select name="with_tva" id="bill_with_tva" class="form-control">
                    <option selected value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="bill_service_description">Description</label>
                <textarea name="description" id="bill_service_description" class="form-control"></textarea>
            </div>
        </div>
    </div>

</form>


