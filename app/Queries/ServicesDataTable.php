<?php

namespace App\Queries;

use App\Models\Service;
use Illuminate\Database\Query\Builder;

/**
 * Class ServicesDataTable.
 */
class ServicesDataTable
{
    /**
     * @return Service|Builder
     */
    public function get(array $input = [])
    {
        /** @var Service $query */
        $query = Service::query();

        $query->when(isset($input['status']) && $input['status'] != Service::STATUS_ALL,
            function (\Illuminate\Database\Eloquent\Builder $q) use ($input) {
                $q->where('status', '=', $input['status']);
            });

        return $query;
    }
}
