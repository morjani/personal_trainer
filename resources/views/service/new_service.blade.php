<form id="form_service">

    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="service_name">Titre</label>
                <input type="text" name="name" id="service_name" class="form-control" value="{{ $service ? $service->name : '' }}">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="service_price">Prix</label>
                <input type="number" name="price" id="service_price" class="form-control" value="{{ $service ? $service->price : '' }}">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="service_category">Categorie</label>
                <select name="category_id" id="service_category" class="form-control">
                    <option selected disabled value="">Sélectionner</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $service && $service->category_id == $category->id ? 'selected' : ''}}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="service_description">Description</label>
                <textarea name="description" id="service_description" class="form-control">{{ $service ? $service->description : '' }}</textarea>
            </div>
        </div>
    </div>

</form>


