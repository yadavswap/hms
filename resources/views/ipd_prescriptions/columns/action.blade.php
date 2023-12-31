@php
    $medicineBill = App\Models\MedicineBill::whereModelType('App\Models\IpdPrescription')->whereModelId($row->id)->first();
@endphp
@if(isset($medicineBill->payment_status) && $medicineBill->payment_status == false)
    <a title="<?php echo __('messages.common.edit') ?>" data-id="{{$row->id}}"
       class="btn px-1 text-primary fs-3 ps-0 editIpdPrescriptionBtn">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
@endif
<a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
   class="deleteIpdPrescriptionBtn btn px-1 text-danger fs-3 ps-0" wire:key="{{$row->id}}">
    <i class="fa-solid fa-trash"></i>
</a>
