<?php

namespace App\Http\Controllers;

use App\Exports\BrandExport;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Models\Medicine;
use App\Repositories\BrandRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BrandController extends AppBaseController
{
    /** @var BrandRepository */
    private $brandRepository;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepository = $brandRepo;
    }

    public function index(): View
    {
        return view('brands.index');
    }

    public function create(): View
    {
        return view('brands.create');
    }

    public function store(CreateBrandRequest $request)
    {
        $input = $request->all();
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->brandRepository->create($input);
        Flash::success(__('messages.medicine_brands').' '.__('messages.common.saved_successfully'));

        return redirect(route('brands.index'));
    }

    public function show(Brand $brand)
    {
        $medicines = $brand->medicines;

        return view('brands.show', compact('medicines', 'brand'));
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Brand $brand, UpdateBrandRequest $request)
    {
        $input = $request->all();
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->brandRepository->update($input, $brand->id);
        Flash::success(__('messages.medicine_brands').' '.__('messages.common.updated_successfully'));

        return redirect(route('brands.index'));
    }

    public function destroy(Brand $brand)
    {
        $medicineBrandModel = [
            Medicine::class,
        ];
        $result = canDelete($medicineBrandModel, 'brand_id', $brand->id);
        if ($result) {
            return $this->sendError(__('messages.medicine_brands').' '.__('messages.common.cant_be_deleted'));
        }
        $brand->delete($brand->id);

        return $this->sendSuccess(__('messages.medicine_brands').' '.__('messages.common.deleted_successfully'));
    }

    public function brandExport()
    {
        return Excel::download(new BrandExport, 'medicine-brands-'.time().'.xlsx');
    }
}
