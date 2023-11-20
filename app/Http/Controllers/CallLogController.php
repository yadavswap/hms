<?php

namespace App\Http\Controllers;

use App\Exports\CallLogExport;
use App\Http\Requests\CreateCallLogRequest;
use App\Http\Requests\UpdateCallLogRequest;
use App\Models\CallLog;
use App\Repositories\CallLogRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CallLogController extends AppBaseController
{
    /**
     * @var  CallLogRepository
     */
    private $CallLogRepository;

    public function __construct(CallLogRepository $callLogRepo)
    {
        $this->CallLogRepository = $callLogRepo;
    }

    public function index()
    {
        $callTypeArr = CallLog::CALLTYPE_ARR;

        return view('call_logs.index', compact('callTypeArr'));
    }

    public function create()
    {
        return view('call_logs.create');
    }

    public function store(CreateCallLogRequest $request)
    {
        $input = $request->all();
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->CallLogRepository->create($input);
        Flash::success(__('messages.call_logs').' '.__('messages.common.saved_successfully'));

        return redirect(route('call_logs.index'));
    }

    public function edit(CallLog $callLog)
    {
        //        $phone = $callLog->phone ?? getCountryCode();
        return view('call_logs.edit', compact('callLog'));
    }

    public function update(UpdateCallLogRequest $request, CallLog $callLog)
    {
        $input = $request->all();
        //        dd($input['phone']);
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->CallLogRepository->update($input, $callLog->id);
        Flash::success(__('messages.call_logs').' '.__('messages.common.updated_successfully'));

        return redirect(route('call_logs.index'));
    }

    public function destroy(CallLog $callLog)
    {
        $callLog->delete();

        return $this->sendSuccess(__('messages.call_logs').' '.__('messages.common.deleted_successfully'));
    }

    public function export()
    {
        return Excel::download(new CallLogExport, 'call-logs-'.time().'.xlsx');
    }
}
