<label class="label-dark" for="machine_nr">{{ __('Machine Nr') }}</label>
<input type="text" id="machine_nr" name="machine_nr" required
    class="{{ !empty($errors->get('machine_nr')) ? 'field-error' : 'field-dark' }} mb-5"
    value="{{ $project->machine_nr ?? old('machine_nr') }}">
@if (!empty($errors->get('machine_nr')))
    @foreach ($errors->get('machine_nr') as $error)
        @include('components.error-message', ['error' => $error, 'hidden' => 'false', 'class' => 'mb-5'])
    @endforeach
@endif

<label class="label-dark" for="country">{{ __('Country') }}</label>
<input type="text" id="country" name="country" required
    class="{{ !empty($errors->get('country')) ? 'field-error' : 'field-dark' }} mb-5"
    value="{{ $project->country ?? old('country') }}">
@if (!empty($errors->get('country')))
    @foreach ($errors->get('country') as $error)
        @include('components.error-message', ['error' => $error, 'hidden' => 'false', 'class' => 'mb-5'])
    @endforeach
@endif

<label class="label-dark" for="coc">{{ __('COC') }}</label>
<input type="text" id="coc" name="coc" required
    class="{{ !empty($errors->get('coc')) ? 'field-error' : 'field-dark' }} mb-5"
    value="{{ $project->coc ?? old('coc') }}">
@if (!empty($errors->get('coc')))
    @foreach ($errors->get('coc') as $error)
        @include('components.error-message', ['error' => $error, 'hidden' => 'false', 'class' => 'mb-5'])
    @endforeach
@endif

<label class="label-dark" for="noticed_issue">{{ __('Noticed Issue') }}</label>
<textarea name="noticed_issue" cols="30" rows="6" class="field-dark mb-5" placeholder="Noticed issue...">{{
    $project->noticed_issue ?? old('noticed_issue')
}}</textarea>

<label class="label-dark" for="proposed_solution">{{ __('Proposed Solution') }}</label>
<textarea name="proposed_solution" cols="30" rows="6" class="field-dark mb-5" placeholder="Proposed solution...">{{
    $project->proposed_solution ?? old('proposed_solution')
}}</textarea>

<label class="label-dark" for="status">{{ __('Status') }}</label>
<select class="w-full cursor-pointer {{ !empty($errors->get('status')) ? 'field-error' : 'field-dark' }} mb-5"
name="status" id="status" required>
    <option value="" disabled selected>{{ __("--Please select--") }}</option>
    @foreach ($statuses as $status)
        <option {{ !empty($project) && $project->status == $status ? 'selected' : '' }}
        value="{{ $status }}">
            {{ $status }}
        </option>
    @endforeach
</select>

<label class="label-dark" for="related_po">{{ __('Related PO') }}</label>
<input type="text" id="related_po" name="related_po" required
    class="{{ !empty($errors->get('related_po')) ? 'field-error' : 'field-dark' }} mb-5"
    value="{{ $project->related_po ?? old('related_po') }}">
@if (!empty($errors->get('related_po')))
    @foreach ($errors->get('related_po') as $error)
        @include('components.error-message', ['error' => $error, 'hidden' => 'false', 'class' => 'mb-5'])
    @endforeach
@endif

<label class="label-dark" for="customer_comment">{{ __('Customer Comment') }}</label>
<textarea name="customer_comment" cols="30" rows="6" class="field-dark mb-5" placeholder="Customer comment...">{{
    $project->customer_comment ?? old('customer_comment')
}}</textarea>

<label class="label-dark" for="commisioner_comment">{{ __('Commisioner Comment') }}</label>
<textarea name="commisioner_comment" cols="30" rows="6" class="field-dark mb-5" placeholder="Commisioner comment...">{{
    $project->commisioner_comment ?? old('commisioner_comment')
}}</textarea>

<label class="label-dark" for="logistics_comment">{{ __('Logistics Comment') }}</label>
<textarea name="logistics_comment" cols="30" rows="6" class="field-dark mb-5" placeholder="Logistics comment...">{{
    $project->logistics_comment ?? old('logistics_comment')
}}</textarea>
