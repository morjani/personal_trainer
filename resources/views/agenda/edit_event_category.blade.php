<form id="form_event_category">

    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="event_category_name">Titre</label>
                <input type="text" name="name" id="event_category_name" class="form-control"
                       value="{{ $event_category ? $event_category->name : '' }}">
            </div>
        </div>
    </div>

</form>


