<?php

namespace App\Exports;

use App\Resource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ResourceExport implements FromCollection, WithHeadings
{
    protected $userId;

    function __construct($userId) {
            $this->userId = $userId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return DB::table('resources')
            ->join('categories', 'resources.category_id', '=', 'categories.id')
            ->where('resources.user_id', '=', $this->userId)
            ->select('resources.name AS resource_name', 'resources.url', 'resources.description', 'categories.name as category_name')
            ->get();
    }

    public function headings() : array
    {
        return ['resource_name', 'url', 'description', 'category_name'];
    }
}
