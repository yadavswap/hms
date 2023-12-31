@extends('layouts.app')
@section('title')
    {{ __('messages.investigation_report.investigation_report_details')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @if(!getLoggedInUser()->hasRole('Patient'))
                    <a class="btn btn-primary edit-btn me-2"
                    href="{{url('investigation-reports/'.$investigationReport->id.'/edit')}}" >{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ route('investigation-reports.index') }}"
                   class="btn btn-outline-primary ms-2">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                </div>
            </div>
                @include('investigation_reports.show_fields')
        </div>
    </div>
@endsection
