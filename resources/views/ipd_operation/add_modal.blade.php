<div id="addIpdOperationModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('messages.common.add') }} {{ __('messages.operation.operation') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'addIpdOperationNewForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="ipdOperationValidationErrorsBox"></div>
                <div class="row">
                    {{ Form::hidden('ipd_patient_department_id', $ipdPatientDepartment->id) }}
                    <div class="form-group col-md-6 mb-0">
                        <div class="form-group mb-5">
                            {{ Form::label('operation_date', __('messages.operation.operation_date') . ':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('operation_date', null, ['class' => 'form-control bg-white', 'id' => 'ipdOperationDate', 'autocomplete' => 'off', 'required']) }}
                        </div>
                    </div>
                    <div class="form-group col-sm-6 mb-5">
                        {{ Form::label('operation_category_id', __('messages.operation_category.operation_category') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('operation_category_id', $operationCategory, null, ['class' => 'form-select select2Selector', 'id' => 'ipdOperationCategoryId', 'required', 'placeholder' => __('messages.common.choose') . ' ' . __('messages.operation_category.operation_category'), 'data-is-charge-edit' => false]) }}
                    </div>
                    <div class="form-group col-sm-6 mb-5">
                        {{ Form::label('operation_id', __('messages.operation.operation_name') . ':', ['class' => 'form-label required']) }}
                        {{ Form::select('operation_id', [null], null, ['class' => 'form-select select2Selector', 'id' => 'ipdOperationsId', 'required', 'data-is-charge-edit' => 0, 'placeholder' => __('messages.common.choose') . ' ' . __('messages.operation.operation_name')]) }}
                    </div>
                    <div class="form-group col-sm-6 mb-5">
                        {{ Form::label('doctor_id', __('messages.ipd_consultant_doctor') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('doctor_id', $doctors, null, ['class' => 'form-select select2Selector', 'id' => 'ipdOperationDoctorId', 'required', 'data-is-charge-edit' => 0, 'placeholder' => __('messages.web_appointment.select_doctor')]) }}
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('assistant_consultant_1', __('messages.ipd_patient_consultant_register.assistant_consultant_1') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('assistant_consultant_1', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('assistant_consultant_2', __('messages.ipd_patient_consultant_register.assistant_consultant_2') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('assistant_consultant_2', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('anesthetist', __('messages.ipd_patient_consultant_register.anesthetist') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('anesthetist', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('anesthesia_type', __('messages.ipd_patient_consultant_register.anesthesia_type') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('anesthesia_type', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('ot_technician', __('messages.operation.ot_technician') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('ot_technician', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('ot_assistant', __('messages.operation.ot_assistant') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('ot_assistant', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('remark', __('messages.blood_issue.remarks'), ['class' => 'form-label']) }}
                            {{ Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <div class="form-group">
                            {{ Form::label('result', __('messages.common.result') . ':', ['class' => 'form-label']) }}
                            {{ Form::textarea('result', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0">
                    {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-3', 'id' => 'btnIpdOperationSave', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
