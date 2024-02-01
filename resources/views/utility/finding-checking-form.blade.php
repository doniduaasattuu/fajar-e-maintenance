{{-- FINDING DESCRIPTION --}}
<div class="mb-3">
    <label for="finding_description" class="fw-semibold form-label">Finding</label>
    <textarea placeholder="Description of findings if any (min 15 character)." class="form-control" name="finding_description" id="finding_description" cols="30" rows="5">{{ isset($finding) ? $finding->description : old('finding_description') }}</textarea>

    @if (!$errors->any() && !isset($motor))
    <div class="form-text text-secondary">To delete findings that have been submitted, leave the finding description blank.</div>
    @endif


    @error('finding_description')
    <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>

{{-- FINDING IMAGE --}}
<div class="mb-3">
    <label for="finding_image" class="fw-semibold form-label">Finding attachment</label>
    <div class="input-group">
        <input class="form-control" type="file" id="finding_image" aria-label="Upload" name="finding_image" accept="image/png, image/jpeg, image/jpg">
        @if( isset($finding) && $finding->image !== null)
        <button class="btn btn-outline-secondary" type="button" id="image"><a target="_blank" class="text-reset text-decoration-none" href="/storage/findings/{{ $finding->image }}">Existing</a></button>
        @endif
    </div>
    @unless ($errors->any())
    <div class="form-text text-secondary">Maximum upload file size: 5 MB.</div>
    @endunless

    @error('finding_image')
    <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>