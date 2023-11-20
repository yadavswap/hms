<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\CreateZoomCredentialRequest;
use App\Http\Requests\LiveConsultationRequest;
use App\Models\LiveConsultation;
use App\Models\UserZoomCredential;
use App\Repositories\LiveConsultationRepository;
use App\Repositories\PatientCaseRepository;
use App\Repositories\ZoomRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App as FacadesApp;

class LiveConsultationController extends AppBaseController
{
    /** @var LiveConsultationRepository */
    private $liveConsultationRepository;

    /** @var ZoomRepository */
    private $zoomRepository;

    /** @var PatientCaseRepository */
    private $patientCaseRepository;

    public function __construct(
        LiveConsultationRepository $liveConsultationRepository,
        PatientCaseRepository $patientCaseRepository,
        ZoomRepository $zoomRepository
    ) {
        $this->liveConsultationRepository = $liveConsultationRepository;
        $this->patientCaseRepository = $patientCaseRepository;
        $this->zoomRepository = $zoomRepository;
    }

    public function index()
    {
        $doctors = $this->patientCaseRepository->getDoctors();
        $patients = $this->patientCaseRepository->getPatients();
        $type = LiveConsultation::STATUS_TYPE;
        $status = LiveConsultation::status;

        return view('live_consultations.index', compact('doctors', 'patients', 'type', 'status'));
    }

    public function store(LiveConsultationRequest $request)
    {
        try {
            $this->liveConsultationRepository->store($request->all());
            $this->liveConsultationRepository->createNotification($request->all());

            return $this->sendSuccess(__('messages.live_consultations').' '.__('messages.common.saved_successfully'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function edit(LiveConsultation $liveConsultation)
    {
        if (checkRecordAccess($liveConsultation->doctor_id)) {
            return $this->sendError(__('messages.live_consultations').' '.__('messages.common.not_found'));
        } else {
            return $this->sendResponse($liveConsultation, 'Live Consultation retrieved successfully.');
        }
    }

    public function update(LiveConsultationRequest $request, LiveConsultation $liveConsultation)
    {
        try {
            $this->liveConsultationRepository->edit($request->all(), $liveConsultation);

            return $this->sendSuccess(__('messages.live_consultations').' '.__('messages.common.updated_successfully'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(LiveConsultation $liveConsultation)
    {
        try {
            if (checkRecordAccess($liveConsultation->doctor_id)) {
                return $this->sendError(__('messages.live_consultations').' '.__('messages.common.not_found'));
            } else {
                $this->zoomRepository->destroyZoomMeeting($liveConsultation->meeting_id);
                $liveConsultation->delete();

                return $this->sendSuccess(__('messages.live_consultations').' '.__('messages.common.deleted_successfully'));
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getTypeNumber(Request $request)
    {
        try {
            $typeNumber = $this->liveConsultationRepository->getTypeNumber($request->all());

            return $this->sendResponse($typeNumber, 'Type Number Retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getChangeStatus(Request $request)
    {
        $liveConsultation = LiveConsultation::findOrFail($request->get('id'));

        if (checkRecordAccess($liveConsultation->doctor_id)) {
            return $this->sendError(__('messages.live_consultations').' '.__('messages.common.not_found'));
        } else {
            $status = null;

            if ($request->get('statusId') == LiveConsultation::STATUS_AWAITED) {
                $status = LiveConsultation::STATUS_AWAITED;
            } elseif ($request->get('statusId') == LiveConsultation::STATUS_CANCELLED) {
                $status = LiveConsultation::STATUS_CANCELLED;
            } else {
                $status = LiveConsultation::STATUS_FINISHED;
            }

            $liveConsultation->update([
                'status' => $status,
            ]);

            return $this->sendsuccess(__('messages.common.status_updated_successfully'));
        }
    }

    public function getLiveStatus(LiveConsultation $liveConsultation)
    {
        if (getLoggedinDoctor() ? checkRecordAccess($liveConsultation->doctor_id) : checkRecordAccess($liveConsultation->patient_id)) {
            return $this->sendError(__('messages.live_consultations').' '.__('messages.common.not_found'));
        } else {
            $data['liveConsultation'] = LiveConsultation::with('user')->find($liveConsultation->id);
            $zoomRepo = App::make(ZoomRepository::class, ['createdBy' => $liveConsultation->created_by]);
            $data['zoomLiveData'] = $zoomRepo->zoomGet($liveConsultation->meeting_id);

            return $this->sendResponse($data, 'Live Status retrieved successfully.');
        }
    }

    public function show(LiveConsultation $liveConsultation)
    {
        if (getLoggedinDoctor() ? checkRecordAccess($liveConsultation->doctor_id) : checkRecordAccess($liveConsultation->patient_id)) {
            return $this->sendError(__('messages.live_consultations').' '.__('messages.common.not_found'));
        } else {
            $data['liveConsultation'] = LiveConsultation::with([
                'user', 'patient.patientUser', 'doctor.doctorUser', 'opdPatient', 'ipdPatient',
            ])->find($liveConsultation->id);
            $data['typeNumber'] = ($liveConsultation->type == LiveConsultation::OPD) ? $liveConsultation->opdPatient->opd_number : $liveConsultation->ipdPatient->ipd_number;

            return $this->sendResponse($data, 'Live Consultation retrieved successfully.');
        }
    }

    public function zoomCredential($id)
    {
        try {
            $data = UserZoomCredential::where('user_id', $id)->first();

            return $this->sendResponse($data, 'User Zoom Credential retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function zoomCredentialCreate(CreateZoomCredentialRequest $request)
    {
        try {
            $this->liveConsultationRepository->createUserZoom($request->all());

            return $this->sendSuccess(__('messages.live_consultation.user_zoom_credential_saved'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function zoomConnect(Request $request)
    {
        $userZoomCredential = UserZoomCredential::where('user_id', getLoggedInUserId())->first();
        if ($userZoomCredential == null) {

            return redirect()->back()->withErrors(__('messages.live_consultation.add_credentials_for_zoom_meeting'));
        }
        $clientID = $userZoomCredential->zoom_api_key;
        $callbackURL = config('app.zoom_callback');
        $url = "https://zoom.us/oauth/authorize?client_id=$clientID&response_type=code&redirect_uri=$callbackURL";

        return redirect($url);
    }

    public function zoomCallback(Request $request)
    {
        $zoomRepo = FacadesApp::make(ZoomRepository::class);
        $zoomRepo->connectWithZoom($request->get('code'));

        return redirect(route('live.consultation.index'));
    }
}
