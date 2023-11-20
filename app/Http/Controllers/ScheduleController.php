<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\HospitalSchedule;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Repositories\ScheduleRepository;
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

class ScheduleController extends AppBaseController
{
    /** @var ScheduleRepository */
    private $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepo)
    {
        $this->scheduleRepository = $scheduleRepo;
    }

    public function index()
    {
        if (getLoggedInUser()->hasRole('Doctor')) {
            $checkDoctorId = Doctor::where('user_id', getLoggedInUserId())->first();
            $checkDoctorSchedule = Schedule::where('doctor_id', $checkDoctorId->id)->get();

            return view('schedules.index', compact('checkDoctorSchedule'));
        }

        return view('schedules.index');
    }

    public function create()
    {
        $data = $this->scheduleRepository->getData();

        $hospitalSchedules = HospitalSchedule::all();
        if (count($hospitalSchedules) == 0) {
            Flash::success(__('messages.hospital_schedules.schedule_not_available'));
        }

        return view('schedules.create', compact('data'));
    }

    public function store(CreateScheduleRequest $request)
    {
        $input = $request->all();

        $schedule = $this->scheduleRepository->store($input);

        Flash::success(__('messages.schedules').' '.__('messages.common.saved_successfully'));

        return redirect(route('schedules.index'));
    }

    public function show(Schedule $schedule)
    {
        if (checkRecordAccess($schedule->doctor_id) && getLoggedInUser()->hasRole('Doctor')) {
            return view('errors.404');
        } else {
            $scheduleDays = ScheduleDay::whereScheduleId($schedule->id)->get();

            return view('schedules.show', compact('scheduleDays', 'schedule'));
        }
    }

    public function edit(Schedule $schedule)
    {
        $data = $this->scheduleRepository->getData();
        $scheduleDays = ScheduleDay::whereScheduleId($schedule->id)->get();

        return view('schedules.edit', compact('schedule', 'data', 'scheduleDays'));
    }

    public function update(Schedule $schedule, UpdateScheduleRequest $request)
    {
        $schedule = $this->scheduleRepository->update($request->all(), $schedule->id);
        Flash::success(__('messages.schedules').' '.__('messages.common.updated_successfully'));

        return redirect()->route('schedules.index');
    }

    public function destroy(Schedule $schedule)
    {
        $doctorModule = [Appointment::class];
        $result = canDelete($doctorModule, 'doctor_id', $schedule->doctor_id);
        if ($result) {
            return $this->sendError(__('messages.schedules').' '.__('messages.common.cant_be_deleted'));
        }

        $this->scheduleRepository->delete($schedule->id);
        ScheduleDay::whereScheduleId($schedule->id)->delete();

        return $this->sendSuccess(__('messages.schedules').' '.__('messages.common.deleted_successfully'));
    }

    public function doctorScheduleList(Request $request)
    {
        $input = $request->all();
        $dayName = '';

        foreach (HospitalSchedule::WEEKDAY_FULL_NAME as $key => $value) {
            if ($value == $input['day_name']) {
                $dayName = $key;
            }
        }

        $check = HospitalSchedule::where('day_of_week', $dayName)->exists();
        if (! $check) {
            return $this->sendError(__('messages.hospital_schedules.this_day_hospital_is_closed'));
        }

        $doctorSchedule = $this->scheduleRepository->getDoctorSchedule($input);

        return $this->sendResponse($doctorSchedule, 'successfully');
    }

    public function schedulesExport()
    {
        return Excel::download(new ScheduleExport, getLoggedInUser()->full_name.'-schedules-'.time().'.xlsx');
    }
}
