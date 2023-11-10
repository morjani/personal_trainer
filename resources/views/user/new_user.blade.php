<form id="form_user">

    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_first_name">Prénom</label>
                <input type="text" name="first_name" id="profile_first_name" class="form-control">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_last_name">Nom</label>
                <input type="text" name="last_name" id="profile_last_name" class="form-control">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_name">Nom d'utilisateur</label>
                <input type="text" name="name" id="profile_name" class="form-control">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="profile_email">Email</label>
                <input type="email" name="email" id="profile_email" class="form-control">
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="user_password">Nouveau mot de passe</label>
                <input type="password" name="password" id="user_password" class="form-control" aria-describedby="passwordHelpBlock">
                <div id="passwordHelpBlock" class="form-text">
                    le mot de passe doit contenir au minimum 8 caractères, à savoir :
                    au moins une lettre minuscule et une lettre majuscule, un caractère spécial et un chiffre.
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="form-group">
                <label for="confirm_password">Confirmation de mot passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="form-group">
                <label for="file_upload">Photo</label>
                <input type="file" id="profile_image" name="image" class="dropify"/>
            </div>
        </div>

    </div>

</form>


