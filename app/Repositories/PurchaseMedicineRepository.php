<?php

namespace App\Repositories;

use App\Models\Accountant;
use App\Models\Address;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\PurchasedMedicine;
use App\Models\PurchaseMedicine;
use App\Models\User;
use Arr;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class AccountantRepository
 *
 * @version February 17, 2020, 5:34 am UTC
 */
class PurchaseMedicineRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'purchase_numeber',
        'purchase_date',
        'bill_number',
        'supplier_name',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return PurchaseMedicine::class;
    }

    public function getMedicine()
    {
        $data['medicines'] = Medicine::all()->pluck('name', 'id')->toArray();

        return $data;
    }

    public function getMedicineList()
    {
        $result = Medicine::all()->pluck('name', 'id')->toArray();

        $medicines = [];
        foreach ($result as $key => $item) {
            $medicines[] = [
                'key' => $key,
                'value' => $item,
            ];
        }

        return $medicines;
    }

    public function getCategoryList()
    {
        $result = Category::all()->pluck('name', 'id')->toArray();

        $category = [];
        foreach ($result as $key => $item) {
            $medicines[] = [
                'key' => $key,
                'value' => $item,
            ];
        }

        return $category;
    }

    public function getCategory()
    {
        $data['categories'] = Category::all()->pluck('name', 'id')->toArray();

        return $data;

    }

    public function store(array $input)
    {
        try {
            DB::beginTransaction();
            $purchaseMedicineArray = Arr::only($input, $this->model->getFillable());
            $purchaseMedicine = PurchaseMedicine::create($purchaseMedicineArray);

            foreach ($input['medicine'] as $key => $value) {

                $purchasedMedicineArray = [
                    'purchase_medicines_id' => $purchaseMedicine->id,
                    'medicine_id' => $input['medicine'][$key],
                    'lot_no' => $input['lot_no'][$key],
                    'tax' => $input['tax_medicine'][$key],
                    'expiry_date' => $input['expiry_date'][$key],
                    'quantity' => $input['quantity'][$key],
                    'amount' => $input['amount'][$key],
                    'tenant_id',
                ];

                PurchasedMedicine::create($purchasedMedicineArray);
                $medicine = Medicine::find($input['medicine'][$key]);
                $medicineQtyArray = [
                    'quantity' => $input['quantity'][$key] + $medicine->quantity,
                    'available_quantity' => $input['quantity'][$key] + $medicine->available_quantity,
                ];
                $medicine->update($medicineQtyArray);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($accountant, $input)
    {
        try {
            unset($input['password']);

            $user = User::find($accountant->user->id);
            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = updateProfileImage($user, $input['image']);
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && ! empty($input['avatar_remove'])) {
                removeFile($user, User::COLLECTION_PROFILE_PICTURES);
            }

            $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            $accountant->user->update($input);
            $accountant->update($input);

            if (! empty($accountant->address)) {
                if (empty($address = Address::prepareAddressArray($input))) {
                    $accountant->address->delete();
                }
                $accountant->address->update($input);
            } else {
                if (! empty($address = Address::prepareAddressArray($input)) && empty($accountant->address)) {
                    $ownerId = $accountant->id;
                    $ownerType = Accountant::class;
                    Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
                }
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
