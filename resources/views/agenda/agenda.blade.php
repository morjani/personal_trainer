<div class="container-fluid" id="page_agenda">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Agenda</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid">
                                <button class="btn font-16 btn-primary" id="btn-new-event"><i class="mdi mdi-plus-circle-outline"></i>
                                    Nouvelle Evenement</button>
                            </div>



                            <div id="external-events" class="mt-2">
                                <br>
                                <p class="text-muted">List des évenements</p>

                                @foreach($event_categories as $event_category)

                                    <div class="external-event fc-event {{ $event_category->class_name }}"
                                         data-action="edit_event_category" data-id="{{ $event_category->id }}"
                                         data-class="{{ $event_category->class_name }}" style="cursor: pointer">
                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{ $event_category->name }}
                                    </div>

                                @endforeach
                            </div>

                            <div class="row justify-content-center mt-5">
                                <img src="assets/images/verification-img.png" alt="" class="img-fluid d-block">
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>

            <div style='clear:both'></div>


            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-3 px-4 border-bottom-0">
                            <h5 class="modal-title" id="modal-title">Event</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>

                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate autocomplete="off">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="event-date-start">Date début</label>
                                            <input class="form-control" placeholder="Date début"
                                                   type="text" name="date_start" id="event-date-start" required value="" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="event-date-end">Date fin</label>
                                            <input class="form-control" placeholder="Date fin"
                                                   type="text" name="date_end" id="event-date-end" required value=""/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Titre</label>
                                            <input type="hidden" id="event-id">
                                            <input class="form-control" placeholder="Titre"
                                                   type="text" name="title" id="event-title" required value="" />
                                            <div class="invalid-feedback">Veuillez fournir un nom d'événement valide</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-control form-select" name="category" id="event-category">
                                                <option value="" selected disabled> --Select-- </option>

                                                @foreach($event_categories as $event_category)

                                                  <option value="{{ $event_category->class_name }}">{{ $event_category->name }}</option>

                                                @endforeach

                                            </select>
                                            <div class="invalid-feedback">Veuillez sélectionner une catégorie d'événement valide</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="event-description">Description</label>
                                            <input type="text" class="form-control" placeholder="Description"
                                                   name="description" id="event-description" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger" id="btn-delete-event">Supprimer</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-success" id="btn-save-event">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->

        </div>
    </div>

</div>

<script>
    let events = <?php echo json_encode($events) ?>;
</script>
