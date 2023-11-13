<!DOCTYPE html>
<html lang="en">

@include('utility.head')

<body>

    @include('utility.navbar')

    <div class="container py-4">

        <!-- <form action="#">
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">Status</label>
                <div class="input-group col-xl-10">
                    <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                    <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">Material Number</label>
                <div class="input-group col-xl-10">
                    <input name="material_number" id="material_number" type="text" class="form-control" value="10019982">
                    <input name="material_number" id="material_number" type="text" class="form-control" value="10019982">
                </div>
            </div>
        </form> -->

        <div class="row">

            <!-- HEADER -->
            <h3>Install Dismantle</h3>
            <!-- HEADER -->

            <div class="col">
                <form action="#">
                    <!-- SEARCH FORM -->
                    <div class="form-group row mb-3">
                        <label class="col-form-label col-xl-10 fw-bold">Equipment</label>
                        <div class="input-group col-xl-10">
                            <input name="equipment" id="equipment" type="text" class="form-control" placeholder="Equipment">
                            <button type="submit" class="btn btn-danger">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- SEARCH FORM -->

                    <!-- DATA -->
                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Motor Status</label>
                        <div class="input-group col-xl-10">
                            <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                                <option value="Repaired">Repaired</option>
                                <option value="Installed">Installed</option>
                                <option value="Available">Available</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Funcloc</label>
                        <div class="input-group col-xl-10">
                            <input name="funcloc" id="funcloc" type="text" class="form-control" placeholder="Funcloc">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Sort Field</label>
                        <div class="input-group col-xl-10">
                            <input name="sort_field" id="sort_field" type="text" class="form-control" placeholder="Sort Field">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Material Number</label>
                        <div class="input-group col-xl-10">
                            <input name="material_number" id="material_number" type="text" class="form-control" placeholder="Material Number">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Description</label>
                        <div class="input-group col-xl-10">
                            <input name="description" id="description" type="text" class="form-control" placeholder="Description">
                        </div>
                    </div>
                    <!-- DATA -->

                    <div class="d-flex">
                        <button type="submit" class="ms-auto mt-3 btn btn-danger">
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2V2Z" />
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                            </svg>
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <div class="col">
                <form action="#">
                    <!-- SEARCH FORM -->
                    <div class="form-group row mb-3">
                        <label class="col-form-label col-xl-10 fw-bold">Equipment</label>
                        <div class="input-group col-xl-10">
                            <input name="equipment" id="equipment" type="text" class="form-control" placeholder="Equipment">
                            <button type="submit" class="btn btn-danger">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- SEARCH FORM -->

                    <!-- DATA -->
                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Motor Status</label>
                        <div class="input-group col-xl-10">
                            <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                                <option value="Repaired">Repaired</option>
                                <option value="Installed">Installed</option>
                                <option value="Available">Available</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Funcloc</label>
                        <div class="input-group col-xl-10">
                            <input name="funcloc" id="funcloc" type="text" class="form-control" placeholder="Funcloc">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Sort Field</label>
                        <div class="input-group col-xl-10">
                            <input name="sort_field" id="sort_field" type="text" class="form-control" placeholder="Sort Field">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Material Number</label>
                        <div class="input-group col-xl-10">
                            <input name="material_number" id="material_number" type="text" class="form-control" placeholder="Material Number">
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <label class="col-form-label col-xl-10 fw-bold">Description</label>
                        <div class="input-group col-xl-10">
                            <input name="description" id="description" type="text" class="form-control" placeholder="Description">
                        </div>
                    </div>
                    <!-- DATA -->

                    <div class="d-flex">
                        <button type="submit" class="ms-auto mt-3 btn btn-danger">
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2V2Z" />
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                            </svg>
                            Save
                        </button>
                    </div>
                </form>
            </div>


        </div>

    </div>
</body>

</html>