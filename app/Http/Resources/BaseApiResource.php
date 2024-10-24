<?php

namespace App\Http\Resources;

use App\Services\Traits\HasPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseApiResource extends JsonResource
{
    use HasPagination;

    /**
     * @param mixed $resource
     *
     * @return [type]
     */
    public static function collection($resource)
    {
        $collection = parent::collection($resource);

        if (method_exists($resource, 'total')) {
            return [
                'data' => $collection,
                'pagination' => (new static([]))->getPaginationData($resource)
            ];
        }

        return [
            'data' => $collection
        ];
    }
    /**
     * @param mixed $request
     * @param mixed $response
     *
     * @return [type]
     */
    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'], $jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}
