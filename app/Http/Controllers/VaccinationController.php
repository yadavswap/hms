<?php

namespace App\Http\Controllers;

use App\Exports\VaccinationExport;
use App\Http\Requests\CreateVaccinationRequest;
use App\Http\Requests\UpdateVaccinationRequest;
use App\Models\VaccinatedPatients;
use App\Models\Vaccination;
use App\Repositories\VaccinationRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VaccinationController extends AppBaseController
{
    /**
     * @var VaccinationRepository
     */
    private $vaccinationRepository;

    public function __construct(VaccinationRepository $vaccinationRepository)
    {
        $this->vaccinationRepository = $vaccinationRepository;
    }

    public function index()
    {
        return view('vaccinations.index');
    }

    public function store(CreateVaccinationRequest $request)
    {
        try {
            $input = $request->all();
            $this->vaccinationRepository->create($input);

            return $this->sendSuccess(__('messages.vaccinated_patient.vaccination').' '.__('messages.common.saved_successfully'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function edit(Vaccination $vaccination)
    {
        return $this->sendResponse($vaccination, 'Vaccination retrieved successfully.');
    }

    public function update(UpdateVaccinationRequest $request, Vaccination $vaccination)
    {
        try {
            $input = $request->all();
            $this->vaccinationRepository->update($input, $vaccination->id);

            return $this->sendSuccess(__('messages.vaccinated_patient.vaccination').' '.__('messages.common.updated_successfully'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(Vaccination $vaccination)
    {
        try {
            $vaccinatedModels = [
                VaccinatedPatients::class,
            ];

            $result = canDelete($vaccinatedModels, 'vaccination_id', $vaccination->id);

            if ($result) {
                return $this->sendError(__('messages.vaccination.vaccinations').' '.__('messages.common.cant_be_deleted'));
            }

            $vaccination->delete();

            return $this->sendSuccess(__('messages.vaccinated_patient.vaccination').' '.__('messages.common.deleted_successfully'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function vaccinationsExport()
    {
        return Excel::download(new VaccinationExport, 'vaccinations-'.time().'.xlsx');
    }
}
