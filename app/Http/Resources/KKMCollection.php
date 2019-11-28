<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class KKMCollection extends ResourceCollection
{
    private $draw;

    public function __construct($draw, $resource)
    {
        $this->draw = $draw ?? 0;

        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'draw' => $this->draw,
        ];
    }
}
