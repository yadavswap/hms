<?php

namespace App\Http\Controllers;

use App\Exports\AmbulanceExport;
use App\Http\Requests\CreateAmbulanceRequest;
use App\Http\Requests\UpdateAmbulanceRequest;
use App\Models\Ambulance;
use App\Models\AmbulanceCall;
use App\Repositories\AmbulanceRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AmbulanceController extends AppBaseController
{
    /** @var AmbulanceRepository */
    private $ambulanceRepository;

    public function __construct(AmbulanceRepository $ambulanceRepo)
    {
        $this->ambulanceRepository = $ambulanceRepo;
    }

    public function index()
    {
        $data['statusArr'] = Ambulance::STATUS_ARR;

        return view('ambulances.index', $data);
    }

    public function create()
    {
        $type = Ambulance::$vehicleType;

        return view('ambulances.create', compact('type'));
    }

    public function store(CreateAmbulanceRequest $request)
    {
        $input = $request->all();
        $input['is_available'] = isset($input['is_available']) ? 1 : 0;
        $input['driver_contact'] = preparePhoneNumber($input, 'driver_contact');

        $this->ambulanceRepository->create($input);
        $this->ambulanceRepository->createNotification();

        Flash::success(__('messages.ambulance.ambulance').' '.__('messages.common.saved_successfully'));

        return redirect(route('ambulances.index'));
    }

    public function show(Ambulance $ambulance)
    {
        $type = Ambulance::$vehicleType;

        return view('ambulances.show', compact('ambulance', 'type'));
    }

    public function edit(Ambulance $ambulance)
    {
        $type = Ambulance::$vehicleType;

        return view('ambulances.edit', compact('ambulance', 'type'));
    }

    public function update(Ambulance $ambulance, UpdateAmbulanceRequest $request)
    {
        $input = $request->all();
        $input['is_available'] = isset($input['is_available']) ? 1 : 0;
        $input['driver_contact'] = preparePhoneNumber($input, 'driver_contact');

        $ambulance = $this->ambulanceRepository->update($input, $ambulance->id);

        Flash::success(__('messages.ambulance.ambulance').' '.__('messages.common.updated_successfully'));

        return redirect(route('ambulances.index'));
    }

    public function destroy(Ambulance $ambulance)
    {
        //        $this->ambulanceRepository->delete($ambulance->id);
        $ambulanceCallModel = [AmbulanceCall::class];
        $result = canDelete($ambulanceCallModel, 'ambulance_id', $ambulance->id);
        if ($result) {
            return $this->sendError(__('messages.ambulance.ambulance').' '.__('messages.common.cant_be_deleted'));
        }

        $ambulance->delete($ambulance->id);

        return $this->sendSuccess(__('messages.ambulance.ambulance').' '.__('messages.common.deleted_successfully'));
    }

    public function isAvailableAmbulance(int $id)
    {
        $ambulance = Ambulance::findOrFail($id);
        $ambulance->is_available = ! $ambulance->is_available;
        $ambulance->update(['is_available' => $ambulance->is_available]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    public function ambulanceExport()
    {
        return Excel::download(new AmbulanceExport, 'ambulances-'.time().'.xlsx');
    }
}
