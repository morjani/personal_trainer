{{--<div class="container-fluid" id="page_settings">
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

</div>--}}

<div class="content-wrapper" id="page_settings">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="form_setting">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Configuration/</span> Landing page</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center cursor-pointer" id="heading_header">
                            <h5 class="mb-0 accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_header"
                                aria-expanded="false" aria-controls="accordion_header">Landing page</h5> <small class="text-muted float-end">Header</small>
                        </div>
                        <div class="card-body accordion-collapse collapse" id="accordion_header" aria-labelledby="heading_header" data-bs-parent="#accordionExample">

                                <div class="mb-3">
                                    <label class="form-label" for="site_logo">Logo</label>
                                    <input type="file" name="site_logo" id="site_logo" data-default-file="{{ $result['site_logo'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="header_banner">Banner</label>
                                    <input type="file" name="header_banner" id="header_banner" data-default-file="{{ $result['header_banner'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="banner_text">Banner text</label>
                                    <textarea class="form-control" name="banner_text" id="banner_text">{{ $result['banner_text'] ?: '' }}</textarea>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center cursor-pointer" id="heading_programme">
                            <h5 class="mb-0 accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_programme"
                                aria-expanded="false" aria-controls="accordion_programme">Landing page</h5> <small class="text-muted float-end">Programme</small>
                        </div>
                        <div class="card-body accordion-collapse collapse" id="accordion_programme" aria-labelledby="heading_programme">
                                <div class="mb-3">
                                    <label class="form-label" for="programme_title">Programmes</label>
                                    <input type="text" class="form-control" name="programme_title"  id="programme_title"
                                           value="{{ $result['programme_title'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="programme_titre">Titre</label>
                                    <input type="text" class="form-control" name="programme_titre"  id="programme_titre"
                                           value="{{ $result['programme_titre'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="programme_description">Description</label>
                                    <textarea class="form-control" name="programme_description" id="programme_description" rows="5">
                                        {{ $result['programme_description'] ?: '' }}
                                    </textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="pragramme_photo_1">photo</label>
                                    <input type="file" name="pragramme_photo_1" id="pragramme_photo_1" data-default-file="{{ $result['pragramme_photo_1'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="programme_personalized">Programme d'entraînement personnalisé</label>
                                    <input type="text" class="form-control" name="programme_personalized"  id="programme_personalized"
                                           value="{{ $result['programme_personalized'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="pragramme_photo_2">photo</label>
                                    <input type="file" name="pragramme_photo_2" id="pragramme_photo_2" data-default-file="{{ $result['pragramme_photo_2'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="programme_personalized_description">Description</label>
                                    <textarea class="form-control" name="programme_personalized_description" id="programme_personalized_description" rows="5">
                                        {{ $result['programme_personalized_description'] ?: '' }}
                                    </textarea>
                                </div>
                                <div class="mb-3 content_elements">
                                    <label class="form-label" for="programme_element">Elements</label>
                                    <textarea class="form-control mb-3" name="programme_element_1" rows="2">{{ $result['programme_element_1'] ?: '' }}</textarea>
                                    <textarea class="form-control mb-3" name="programme_element_2" rows="2">{{ $result['programme_element_2'] ?: '' }}</textarea>
                                    <textarea class="form-control mb-3" name="programme_element_3" rows="2">{{ $result['programme_element_3'] ?: '' }}</textarea>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center cursor-pointer" id="heading_package">
                            <h5 class="mb-0 accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_package"
                                aria-expanded="false" aria-controls="accordion_package">Landing page</h5> <small class="text-muted float-end">Packages</small>
                        </div>
                        <div class="card-body accordion-collapse collapse" id="accordion_package" aria-labelledby="heading_package">
                                <div class="mb-3">
                                    <label class="form-label" for="package_title">Packages</label>
                                    <input type="text" class="form-control" name="package_title"  id="package_title" value="{{ $result['package_title'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="programme_titre">Titre</label>
                                    <input type="text" class="form-control" name="package_titre"  id="package_titre" value="{{ $result['package_titre'] ?: '' }}" />
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center cursor-pointer" id="heading_testimonial">
                            <h5 class="mb-0 accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_testimonial"
                                aria-expanded="false" aria-controls="accordion_testimonial">Landing page</h5> <small class="text-muted float-end">Temoignages</small>
                        </div>
                        <div class="card-body accordion-collapse collapse" id="accordion_testimonial" aria-labelledby="heading_testimonial">
                                <div class="mb-3">
                                    <label class="form-label" for="testimonial_title">Temoignages</label>
                                    <input type="text" class="form-control" name="testimonial_title"  id="testimonial_title" value="{{ $result['testimonial_title'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="testimonial_description">Description</label>
                                    <textarea class="form-control" name="testimonial_description" id="testimonial_description" rows="3">{{ $result['testimonial_description'] ?: '' }}</textarea>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center cursor-pointer" id="heading_contact">
                            <h5 class="mb-0 accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_contact"
                                aria-expanded="false" aria-controls="accordion_contact">Landing page</h5> <small class="text-muted float-end">Contact</small>
                        </div>
                        <div class="card-body accordion-collapse collapse" id="accordion_contact" aria-labelledby="heading_contact">
                                <div class="mb-3">
                                    <label class="form-label" for="contact_titre">Contact titre</label>
                                    <input type="text" class="form-control" name="contact_titre"  id="contact_titre" value="{{ $result['contact_titre'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contact_titre">Téléphone</label>
                                    <input type="text" class="form-control mb-3" name="contact_phone"  id="contact_phone" value="{{ $result['contact_phone'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contact_email">Email</label>
                                    <input type="text" class="form-control mb-3" name="contact_email"  id="contact_email" value="{{ $result['contact_email'] ?: '' }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="contact_address">Adresse</label>
                                    <textarea class="form-control" name="contact_address" id="contact_address" rows="2">{{ $result['contact_address'] ?: '' }}</textarea>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="save_setting" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>


