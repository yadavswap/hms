@if ($row->opd_diagnosis_document_url)
    <a data-turbo="false" href="{{ url('opd-diagnosis-download' . '/' . $row->id) }}"> {{ __('messages.document.download') }}
    </a>
@else
    {{ __('messages.common.n/a') }}
@endif
