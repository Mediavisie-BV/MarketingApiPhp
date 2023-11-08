<?php

namespace MediavisieBv\MarketingApi\Traits;

use JsonMapper;
use MediavisieBv\MarketingApi\Models\Request\AttributeCreateRequest;
use MediavisieBv\MarketingApi\Models\Request\AttributeUpdateRequest;
use MediavisieBv\MarketingApi\Models\Responses\AttributesResponse;
use MediavisieBv\MarketingApi\Models\Responses\MessageResponse;
use MediavisieBv\MarketingApi\Tools\Support;

trait AttributesTrait
{
    public function getAttributes()
    {
        try {
            $result = $this->getData('/v1/Attributes/Attributes');
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, AttributesResponse::class);
        } catch (\Exception $e) {
            $data = new AttributesResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }

    public function createAttribute(AttributeCreateRequest $attributeCreateRequest)
    {
        try {
            $result = $this->executeRequest('/v1/Attributes/Attribute', 'POST', $attributeCreateRequest);
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, MessageResponse::class);
        } catch (\Exception $e) {
            $data = new MessageResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }

    public function updateAttribute($id, AttributeUpdateRequest $attributeUpdateRequest)
    {
        try {
            if (Support::isUuid($id) === false) {
                throw new \Exception('Invalid id');
            }

            $result = $this->executeRequest('/v1/Attributes/Attribute/'.$id, 'PUT', $attributeUpdateRequest);
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, MessageResponse::class);
        } catch (\Exception $e) {
            $data = new MessageResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }

    public function deleteAttribute($id)
    {
        try {
            $result = $this->executeRequest('/v1/Attributes/Attribute/' . $id, 'DELETE');
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, MessageResponse::class);
        } catch (\Exception $e) {
            $data = new MessageResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }
}