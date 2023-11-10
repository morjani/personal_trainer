<form id="form_profile">

    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_first_name">Prénom</label>
                <input type="text" name="first_name" id="profile_first_name" class="form-control" value="{{ $profile ? $profile->first_name : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_last_name">Nom</label>
                <input type="text" name="last_name" id="profile_last_name" class="form-control" value="{{ $profile ? $profile->last_name : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_name">Nom d'utilisateur</label>
                <input type="text" name="name" id="profile_name" class="form-control" value="{{ $profile ? $profile->name : '' }}">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_email">Email</label>
                <input type="email" name="email" id="profile_email" class="form-control" value="{{ $profile ? $profile->email : '' }}">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="file_upload">Photo</label>
                <input type="file" id="profile_image" name="image" class="dropify" data-default-file="{{ $attachement ? $attachement->link : '' }}"/>
            </div>
        </div>

    </div>

</form>


