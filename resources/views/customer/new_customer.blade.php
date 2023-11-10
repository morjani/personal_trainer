<form id="form_customer" enctype="multipart/form-data">
    <div class="hidden">
        <input type="hidden" name="prospect" value="{{ $prospect  }}">
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_last_name">Nom</label>
                <input type="text" name="last_name" id="customer_last_name" class="form-control" value="{{ $customer ? $customer->last_name : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_phone">Téléphone</label>
                <input type="text" name="phone" id="customer_phone" class="form-control" value="{{ $customer ? $customer->phone : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_mobile">Portable</label>
                <input type="text" name="mobile" id="customer_mobile" class="form-control" value="{{ $customer ? $customer->mobile : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_fax">Fax</label>
                <input type="text" name="fax" id="customer_fax" class="form-control" value="{{ $customer ? $customer->fax : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_email">Email</label>
                <input type="email" name="email" id="customer_email" class="form-control" value="{{ $customer ? $customer->email : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_country">Pays</label>
                <select name="country_id" id="customer_country" class="form-control">
                    <option selected disabled value="">Sélectionner</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $customer && $customer->country_id == $country->id ? 'selected' : ''}}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_city">Ville</label>
                <select name="city_id" id="customer_city" class="form-control">
                    <option selected disabled value="">Sélectionner</option>
                    @if($customer and $city)
                        <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_zip_code">Code postale</label>
                <input type="text" name="zip_code" id="customer_zip_code" class="form-control" value="{{ $customer ? $customer->zip_code : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_ice">ICE</label>
                <input type="text" name="ice" id="customer_ice" class="form-control" value="{{ $customer ? $customer->ice : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="customer_address">Adresse</label>
                <textarea name="address" id="customer_address" class="form-control" rows="4">{{ $customer ? $customer->address : '' }}</textarea>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="file_upload">Photo</label>
                <input type="file" id="file_upload" name="image" class="dropify" data-default-file="{{ $attachement ? $attachement->link : '' }}"/>
            </div>
        </div>

    </div>

</form>


