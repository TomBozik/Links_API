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
        $resources = DB::table('resources')->join('categories', 'resources.category_id', '=', 'categories.id')->where('resources.user_id', '=', $this->userId)->select('resources.name AS resource_name', 'resources.url', 'resources.description', 'categories.name as category_name', 'resources.id')->get();

        $resources->map(function($resource){
            $tags = DB::table('tags')->join('resource_tag', 'resource_tag.tag_id', '=', 'tags.id')->where('resource_tag.resource_id', '=', $resource->id)->get('name')->pluck('name')->toArray();
            $resource->tags = $tags;
            unset($resource->id);
            return $resource;
        });

        return $resources;
    }

    public function headings() : array
    {
        return ['resource_name', 'url', 'description', 'category_name', 'tags'];
    }
}
