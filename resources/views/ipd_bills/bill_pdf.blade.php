<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/img/logo.jpg') }}" type="image/png">
    <title>{{ __('messages.bill.bill_details') }}</title>
    <link href="{{ asset('assets/css/bill-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }
    </style>
    @if (getCurrentCurrency() == 'inr')
        <style>
            body {
                font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        </style>
    @endif
</head>

<body>
    <table width="100%">
        <tr>
            <td class="header-left">
                <div class="main-heading">{{ __('messages.bill.bill') }}</div>
            </td>
            <td class="header-right">
                <div class="logo"><img width="100px" src="{{ $setting['app_logo'] }}" alt=""></div>
                <div class="hospital-name">{{ $setting['app_name'] }}</div>
                <div class="hospital-name font-color-gray">{{ $setting['hospital_address'] }}</div>
                <div>
                    <span class="font-weight-bold patient-detail-heading">{{ __('messages.bill.bill_date') }}:</span>
                    {{ \Carbon\Carbon::parse($bill['ipd_patient_department']->bill->updated_at)->format('jS M,Y g:i A') }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%">
                    <tr>
                        <td colspan="2" class="font-weight-bold patient-detail-heading">
                            {{ __('messages.patient.patient_details') }}</td>
                    </tr>
                    <tr>
                        <td class="patient-details">
                            <table class="patient-detail-one">
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.ipd_number') }}:</td>
                                    <td>#{{ $bill['ipd_patient_department']->ipd_number }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.investigation_report.patient') }}:
                                    </td>
                                    <td>{{ $bill['ipd_patient_department']->patient->user->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.user.email') }}:</td>
                                    <td>{{ $bill['ipd_patient_department']->patient->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.bill.cell_no') }}:</td>
                                    <td>{{ !empty($bill['ipd_patient_department']->patient->user->phone) ? $bill['ipd_patient_department']->patient->user->phone : __('messages.common.n/a') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.user.gender') }}:</td>
                                    <td>{{ $bill['ipd_patient_department']->patient->user->gender == 0 ? __('messages.user.male') : __('messages.user.female') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.user.blood_group') }}:</td>
                                    <td>{{ !empty($bill['ipd_patient_department']->patient->user->blood_group) ? $bill['ipd_patient_department']->patient->user->blood_group : __('messages.common.n/a') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="ml-5">
                            <table class="patient-detail-two">
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.case_id') }}:</td>
                                    <td>{{ !empty($bill['ipd_atient_department']->case_id) ? '#' . $bill['ipd_atient_department']->patientCase->case_id : __('messages.common.n/a') }}
                                    </td>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.doctor_id') }}:</td>
                                    <td>{{ $bill['ipd_patient_department']->doctor->user->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.admission_date') }}:</td>
                                    <td> {{ date('jS M, Y m:s', strtotime($bill['ipd_patient_department']->admission_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.bed_id') }}:</td>
                                    <td>{{ $bill['ipd_patient_department']->bed->name }}
                                        ({{ $bill['ipd_patient_department']->bedType->title }})
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.height') }}:</td>
                                    <td>{{ !empty($bill['ipd_patient_department']->height) ? $bill['ipd_patient_department']->height : __('messages.common.n/a') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('messages.ipd_patient.weight') }}:</td>
                                    <td>{{ !empty($bill['ipd_patient_department']->weight) ? $bill['ipd_patient_department']->weight : __('messages.common.n/a') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table mt-4 w-100 items-table" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-left">{{ __('messages.account.type') }}</th>
                            <th>{{ __('messages.medicine.category') }}</th>
                            <th>{{ __('messages.ipd_patient_charges.date') }}</th>
                            <th class="text-right">{{ __('messages.invoice.amount') }} (<b>{{ $currencySymbol }}</b>)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bill['charges'] as $charge)
                            <tr>
                                <td>{{ $charge->charge_type }}</td>
                                <td>{{ $charge->chargecategory->name }}</td>
                                <td>{{ $charge->date->format('d/m/Y') }}</td>
                                {{--                        <td class="text-right">{{ number_format($charge->applied_charge) }}</td> --}}
                                <td class="text-right">
                                    {{ checkNumberFormat($charge->applied_charge, strtoupper(getCurrentCurrency())) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="number-align">
                        <tr>
                            <td class="text-right number-align" colspan="4">
                                {{ __('messages.bill.total_amount') . ':' }}
                                <span class="pl-2 font-weight-bold">
                                    {{ checkNumberFormat($bill['total_charges'], strtoupper(getCurrentCurrency())) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table w-100 items-table" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('messages.ipd_payments.payment_mode') }}</th>
                            <th scope="col">{{ __('messages.ipd_patient_charges.date') }}</th>
                            <th scope="col" class="text-right">{{ __('messages.ipd_bill.paid_amount') }}
                                (<b>{{ $currencySymbol }}</b>)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bill['payments'] as $payment)
                            <tr>
                                <td>{{ $payment->payment_mode_name }}</td>
                                <td>{{ $payment->date->format('d/m/Y') }}</td>
                                <td class="text-right">
                                    {{ checkNumberFormat($payment->amount, strtoupper(getCurrentCurrency())) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="number-align">
                        <tr>
                            <td class="text-right number-align" colspan="4">
                                {{ __('messages.bill.total_amount') . ':' }}
                                <span class="pl-2 font-weight-bold">
                                    <span>
                                        {{ checkNumberFormat($bill['total_payment'], strtoupper(getCurrentCurrency())) }}
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table number-align w-100" width="100%">
                    <thead class="thead-light">
                        <tr class="patient-detail-heading">
                            <th class="h5 font-weight-bold number-align" scope="col" colspan="4">
                                {{ __('messages.bill.bill_summary') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.paid_amount') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['total_payment'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.total_charges') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['total_charges'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.gross_total') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['gross_total'] > 0 ? $bill['gross_total'] : 0 }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.discount_in_percentage') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['discount_in_percentage'] . '%' }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.tax_in_percentage') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['tax_in_percentage'] . '%' }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="number-align">
                                {{ __('messages.ipd_bill.other_charges') . ':' }}
                            </td>
                            <td class="font-weight-bold">{{ $bill['other_charges'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-weight-bold">
                                {{ __('messages.ipd_bill.net_payable_amount') . ':' }}
                            </td>
                            <td class="font-weight-bold">
                                {{ checkNumberFormat($bill['last_net_payable_amount'], strtoupper(getCurrentCurrency())) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>
