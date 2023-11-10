<form id="form_category">

    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="category_name">Titre</label>
                <input type="text" name="name" id="category_name" class="form-control" value="{{ $category ? $category->name : '' }}">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="category_description">Description</label>
                <textarea name="description" id="category_description" class="form-control">{{ $category ? $category->description : '' }}</textarea>
            </div>
        </div>
    </div>

</form>


