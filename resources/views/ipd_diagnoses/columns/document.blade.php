@if ($row->ipd_diagnosis_document_url != '')
    <a data-turbo="false" class="text-decoration-none"
        href="{{ url('ipd-diagnosis-download') . '/' . $row->id }}">{{ __('messages.document.download') }}</a>
@else
    {{ __('messages.common.n/a') }}
@endif
