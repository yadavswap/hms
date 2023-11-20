<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Department;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PatientRepository
 *
 * @version February 14, 2020, 5:53 am UTC
 */
class PatientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Patient::class;
    }

    public function store($input, $mail = true)
    {
        try {
            $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['department_id'] = Department::whereName('Patient')->first()->id;
            $input['password'] = Hash::make($input['password']);
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            $user = User::create($input);
            if ($mail) {
                $user->sendEmailVerificationNotification();
            }

            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = storeProfileImage($user, $input['image']);
            }

            $patient = Patient::create(['user_id' => $user->id]);

            $ownerId = $patient->id;
            $ownerType = Patient::class;

            if (! empty($address = Address::prepareAddressArray($input))) {
                Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
            }

            $user->update(['owner_id' => $ownerId, 'owner_type' => $ownerType]);
            $user->assignRole($input['department_id']);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function update($input, $patient)
    {
        try {
            unset($input['password']);

            $user = User::find($patient->patientUser->id);
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && ! empty($input['avatar_remove'])) {
                removeFile($user, User::COLLECTION_PROFILE_PICTURES);
            }
            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = updateProfileImage($user, $input['image']);
            }

            $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            $patient->patientUser->update($input);
            $patient->update($input);

            if (! empty($patient->address)) {
                if (empty($address = Address::prepareAddressArray($input))) {
                    $patient->address->delete();
                }
                $patient->address->update($input);
            } else {
                if (! empty($address = Address::prepareAddressArray($input)) && empty($patient->address)) {
                    $ownerId = $patient->id;
                    $ownerType = Patient::class;
                    Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
                }
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function getPatients()
    {
        //        $user = Auth::user();
        //        if ($user->hasRole('Doctor')) {
        //            $patients = getPatientsList($user->owner_id);
        //        } else {
        //            $patients = Patient::with('patientUser')
        //                ->whereHas('patientUser', function (Builder $query) {
        //                    $query->where('status', 1);
        //                })->get()->pluck('patientUser.full_name', 'id')->sort();
        //        }
        return Patient::with('patientUser')
            ->whereHas('patientUser', function (Builder $query) {
                $query->where('status', 1);
            })->get()->pluck('patientUser.full_name', 'id')->sort();
    }

    public function getPatientAssociatedData($patientId)
    {
        $patientData = Patient::with([
            'bills', 'invoices', 'appointments.doctor.doctorUser', 'appointments.doctor.department', 'admissions.doctor.doctorUser',
            'cases.doctor.doctorUser', 'advancedpayments', 'documents.media', 'documents.documentType', 'patientUser',
            'vaccinations.vaccination',
            'address',
        ])->find($patientId);

        return $patientData;
    }

    public function createNotification($input)
    {
        try {
            $receptionists = Receptionist::pluck('user_id', 'id')->toArray();

            $userIds = [];
            foreach ($receptionists as $key => $userId) {
                $userIds[$userId] = Notification::NOTIFICATION_FOR[Notification::RECEPTIONIST];
            }
            $users = getAllNotificationUser($userIds);

            foreach ($users as $key => $notification) {
                if (isset($key)) {
                    addNotification([
                        Notification::NOTIFICATION_TYPE['Patient'],
                        $key,
                        $notification,
                        $input['first_name'].' '.$input['last_name'].' added as a patient.',
                    ]);
                }
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
