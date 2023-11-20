<div>
    <div class="mt-7 overflow-hidden">
        <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap justify-content-between text-nowrap" id="myTab"
            role="tablist">
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0 active" id="ipdOverview" data-bs-toggle="tab" data-bs-target="#poverview"
                    type="button" role="tab" aria-controls="overview" aria-selected="true">
                    {{ __('messages.overview') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="cases-tab" data-bs-toggle="tab" data-bs-target="#ipdDiagnosis"
                    type="button" role="tab" aria-controls="cases" aria-selected="false">
                    {{ __('messages.patient_diagnosis_test.diagnosis') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0 ipdConsultantInstruction" id="patients-tab" data-bs-toggle="tab"
                    data-bs-target="#ipdConsultantInstruction" type="button" role="tab" aria-controls="patients"
                    aria-selected="false">
                    {{ __('messages.ipd_patient_consultant_register.consultant_instruction') }}
                </button>
            </li>
            {{--            <li class="nav-item position-relative me-7 mb-3" role="presentation"> --}}
            {{--                <button class="nav-link p-0 ipdOperation" id="patients-tab" data-bs-toggle="tab" data-bs-target="#ipdOperation" type="button" role="tab" aria-controls="patients" aria-selected="false"> --}}
            {{--                    Operations --}}
            {{--                </button> --}}
            {{--            </li> --}}
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0 ipdCharges" id="patients-tab" data-bs-toggle="tab"
                    data-bs-target="#ipdCharges" type="button" role="tab" aria-controls="patients"
                    aria-selected="false">
                    {{ __('messages.charges') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0 ipdPrescriptions" id="patients-tab" data-bs-toggle="tab"
                    data-bs-target="#ipdPrescriptions" type="button" role="tab" aria-controls="patients"
                    aria-selected="false">
                    {{ __('messages.ipd_prescription') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="patients-tab" data-bs-toggle="tab" data-bs-target="#ipdTimelines"
                    type="button" role="tab" aria-controls="patients" aria-selected="false">
                    {{ __('messages.ipd_timelines') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0 ipdPayment" id="patients-tab" data-bs-toggle="tab"
                    data-bs-target="#ipdPayment" type="button" role="tab" aria-controls="patients"
                    aria-selected="false">
                    {{ __('messages.account.payments') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="patients-tab" data-bs-toggle="tab" data-bs-target="#ipdBill"
                    type="button" role="tab" aria-controls="patients" aria-selected="false">
                    {{ __('messages.bill.bill') }}
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="poverview" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <h2 class="mb-0">
                                    <a href="" class="text-decoration-none">
                                        {{ $ipdPatientDepartment->patient->patientUser->full_name }}
                                    </a>
                                </h2>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col-lg-3 text-center">
                                    <div class="image image-circle image-small">
                                        <img src="{{ $ipdPatientDepartment->patient->patientUser->image_url }}"
                                            alt="image" />
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <table class="table  mb-0">
                                        <tbody>
                                            <tr>
                                                <td>{{ __('messages.user.gender') }}</td>
                                                <td>{{ $ipdPatientDepartment->patient->patientUser->gender == 0 ? 'Male' : 'Female' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('messages.user.email') }}</td>
                                                <td>{{ $ipdPatientDepartment->patient->patientUser->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('messages.user.phone') }}</td>
                                                <td>{{ $ipdPatientDepartment->patient->patientUser->phone ?? __('messages.common.n/a') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-9">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>{{ __('messages.case.case_id') }}</td>
                                                <td>{{ !empty($ipdPatientDepartment->patientCase) ? $ipdPatientDepartment->patientCase->case_id : __('messages.common.n/a') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('messages.ipd_patient.ipd_number') }}</td>
                                                <td>{{ $ipdPatientDepartment->ipd_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="white-space-nowrap" width="40%">
                                                    {{ __('messages.ipd_patient.admission_date') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($ipdPatientDepartment->admission_date)->translatedFormat('jS M, Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('messages.ipd_patient.bed_id') }}</td>
                                                <td>{{ $ipdPatientDepartment->bed->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <p><i class="fa fa-tag"></i> {{ __('messages.ipd_patient.symptoms') }}</p>
                                <ul class="timeline-ps-46 mb-0">
                                    <li>
                                        <div>
                                            {!! !empty($ipdPatientDepartment->symptoms)
                                                ? nl2br(e($ipdPatientDepartment->symptoms))
                                                : __('messages.common.n/a') !!}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-lg-10">
                                    <h3 class="text-uppercase fs-5">
                                        {{ __('messages.ipd_patient_consultant_register.consultant_doctor') }}</h3>
                                </div>
                            </div>
                            <div id="consultant-div">
                                {{--                                @if (count($consultantDoctor) == 0) --}}
                                <tr class="text-center">
                                    <td colspan="4">
                                        <div class="mb-5">
                                            {{ __('messages.common.no') . ' ' . __('messages.ipd_consultant_doctor') }}
                                        </div>
                                    </td>
                                </tr>
                            </div>

                            <div class="row">
                                <div class="mb-5">
                                    <h3 class="text-uppercase fs-5">{{ __('messages.ipd_patient_timeline.timeline') }}
                                    </h3>
                                </div>
                                <div class="mb-5">{{ __('messages.ipd_patient_timeline.no_timeline_found') }}</div>
                            </div>
                            <div class="mb-10 mt-5">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-10">
                                <div class="d-flex justify-content-between">
                                    <h3 class="text-uppercase fs-5 mb-4">{{ __('messages.payment.payment') }}
                                        /{{ __('messages.billing') }}</h3>
                                    @if ($bill['total_payment'] && $bill['total_charges'] != 0)
                                        <h5 class="text-gray-700">
                                            {{ round(($bill['total_payment'] / $bill['total_charges']) * 100, 2) }}
                                            %</h5>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ round(($bill['total_payment'] / $bill['total_charges']) * 100, 2) }}%"
                                        aria-valuenow="{{ round(($bill['total_payment'] / $bill['total_charges']) * 100, 2) }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @else
                                <h5 class="text-gray-700">0%</h5>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            @endif
                        </div>
                        <div class="mb-10">
                            <div class="d-flex justify-content-between">
                                <h3 class="text-uppercase fs-5">{{ __('messages.prescription.prescription') }}</h3>
                                @if (App\Models\IpdPrescription::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 5)
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link ipd-prescription-btn btn btn-primary btn-sm text-capitalize text-white"
                                                data-bs-toggle="tab" data-bs-target="#ipdPrescriptions"
                                                id="cases-tab" type="button" role="tab" aria-controls="cases"
                                                aria-selected="false">view all</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (App\Models\IpdPrescription::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 0)
                                <livewire:overview-ipd-prescription-table
                                    ipdPrescriptionId="{{ $ipdPatientDepartment->id }}" />
                            @else
                                <table class="table table-striped">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient.ipd_number') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.common.created_on') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr>
                                            <td class="text-center" colspan="2">
                                                {{ __('messages.no_data_available') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div class="mb-10">
                            <div class="d-flex justify-content-between">
                                <h3 class="text-uppercase fs-5">
                                    {{ __('messages.ipd_patient_consultant_register.consultant_instruction') }}</h3>
                                @if (App\Models\IpdConsultantRegister::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 5)
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link ipd-consultant-btn btn btn-primary btn-sm text-capitalize text-white"
                                                data-bs-toggle="tab" data-bs-target="#ipdConsultantInstruction"
                                                id="cases-tab" type="button" role="tab" aria-controls="cases"
                                                aria-selected="false">view all</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (App\Models\IpdConsultantRegister::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 0)
                                <livewire:overview-ipd-consultant-table
                                    ipdConsultantId="{{ $ipdPatientDepartment->id }}" />
                            @else
                                <table class="table table-striped">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">
                                                {{ __('messages.investigation_report.doctor') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_consultant_register.applied_date') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_consultant_register.instruction_date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                {{ __('messages.no_data_available') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="mb-10">
                            <div class="d-flex justify-content-between">
                                <h3 class="text-uppercase fs-5">{{ __('messages.charges') }}</h3>
                                @if (App\Models\IpdCharge::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 5)
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link ipd-charges-btn btn btn-primary btn-sm text-capitalize text-white"
                                                data-bs-toggle="tab" data-bs-target="#ipdCharges" type="button"
                                                role="tab" aria-controls="cases" aria-selected="false">view
                                                all</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (App\Models\IpdCharge::where('ipd_patient_department_id', $ipdPatientDepartment->id)->count() > 0)
                                <livewire:overview-ipd-charges-table ipdChargeId="{{ $ipdPatientDepartment->id }}" />
                            @else
                                <table class="table table-striped">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">
                                                {{ __('messages.investigation_report.date') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.charge_category.charge_type') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.charge.code') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.charge.standard_charge') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_charges.applied_charge') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                {{ __('messages.no_data_available') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="mb-10">
                            <div class="d-flex justify-content-between">
                                <h3 class="text-uppercase fs-5">{{ __('messages.payment.payment') }}</h3>
                                @if (App\Models\IpdPayment::whereIpdPatientDepartmentId($ipdPatientDepartment->id)->count() > 5)
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link ipd-payment-btn btn btn-primary btn-sm text-capitalize text-white"
                                                data-bs-toggle="tab" data-bs-target="#ipdPayment" type="button"
                                                role="tab" aria-controls="cases" aria-selected="false">view
                                                all</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (App\Models\IpdPayment::whereIpdPatientDepartmentId($ipdPatientDepartment->id)->count() > 5)
                                <livewire:overview-ipd-payment-table ipdPaymentId="{{ $ipdPatientDepartment->id }}" />
                            @else
                                <table class="table table-striped">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">
                                                {{ __('messages.investigation_report.date') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ambulance_call.amount') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_payments.payment_mode') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.document.document') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ambulance.note') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                {{ __('messages.no_data_available') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="mb-10">
                            <div class="d-flex justify-content-between">
                                <h3 class="text-uppercase fs-5">{{ __('messages.patient_diagnosis_test.diagnosis') }}
                                </h3>
                                @if (App\Models\IpdDiagnosis::whereIpdPatientDepartmentId($ipdPatientDepartment->id)->count() > 5)
                                    <ul class="nav" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link ipd-diagnosis-btn btn btn-primary btn-sm text-capitalize text-white"
                                                data-bs-toggle="tab" data-bs-target="#ipdDiagnosis" id="cases-tab"
                                                type="button" role="tab" aria-controls="cases"
                                                aria-selected="false">view
                                                all</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (App\Models\IpdDiagnosis::whereIpdPatientDepartmentId($ipdPatientDepartment->id)->count() > 0)
                                <livewire:overview-ipd-diagnosis-table
                                    ipdDiagnosisId="{{ $ipdPatientDepartment->id }}" />
                            @else
                                <table class="table table-striped">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_diagnosis.report_type') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_diagnosis.report_date') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.document.document') }}
                                            </th>

                                            <th scope="col" class="">
                                                {{ __('messages.ipd_patient_diagnosis.description') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                {{ __('messages.no_data_available') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="ipdDiagnosis" role="tabpanel">
        <livewire:ipd-patient-diagnosis-table ipdPatientDepartment="{{ $ipdPatientDepartment->id }}" />
    </div>
    <div class="tab-pane fade" id="ipdConsultantInstruction" role="tabpanel">
        <livewire:ipd-consultant-register-patient-table ipdPatientDepartment="{{ $ipdPatientDepartment->id }}" />
    </div>
    <div class="tab-pane fade" id="ipdCharges" role="tabpanel">
        <livewire:ipd-charge-patient-table ipdPatientDepartment="{{ $ipdPatientDepartment->id }}" />
    </div>
    <div class="tab-pane fade" id="ipdPrescriptions" role="tabpanel">
        <livewire:ipd-prescription-table ipdPrescriptionId="{{ $ipdPatientDepartment->id }}" />
    </div>
    <div class="tab-pane fade" id="ipdTimelines" role="tabpanel">
        <div id="ipdTimelines"></div>
    </div>
    <div class="tab-pane fade" id="ipdPayment" role="tabpanel">
        {{--            <input type="hidden" name="charge_currency" value="{{ $bill['payment_currency']->currency_symbol ?? getCurrentCurrency() }}" id="payment_currency"> --}}
        {{--            @dump($ipdPatientDepartment->bill->net_payable_amount > 0) --}}
        @if ($ipdPatientDepartment->bill && $ipdPatientDepartment->bill->net_payable_amount > 0)
            {{--                        <div class="card-title"> --}}
            <button id="ipdPaymentBtn" class="btn btn-primary filter-container__btn float-end" data-turbo="false">
                {{ __('messages.ipd_payments.make_payment') }}
            </button>
            {{--                        </div> --}}
            {{--            @dump($bill['patient_net_payable_amount']) --}}
            {{--                <input type="hidden" name="net_payable_amount" id="billAmount" --}}
            {{--                       value="{{ $ipdPatientDepartment->bill->net_payable_amount }}"/> --}}
            <input type="hidden" name="net_payable_amount" id="billAmount"
                value="{{ $bill['patient_net_payable_amount'] }}" />
            <input type="hidden" name="ipd_number" id="ipdNumber"
                value="{{ $ipdPatientDepartment->ipd_number }}" />
        @endif
        <livewire:ipd-payment-table ipdPatientDepartmentId="{{ $ipdPatientDepartment->id }}" />
    </div>
    <div class="tab-pane fade" id="ipdBill" role="tabpanel">
        <div class="table-responsive viewList overflow-hidden">
            <div class="card">
                <div class="card-body">
                    @include('ipd_bills.table')
                </div>
            </div>
        </div>
    </div>
</div>
