<?php

namespace MediavisieBv\MarketingApi\Traits;

use JsonMapper;
use MediavisieBv\MarketingApi\Models\Objects\Profile;
use MediavisieBv\MarketingApi\Models\Responses\MessageResponse;
use MediavisieBv\MarketingApi\Models\Responses\ProfileResponse;
use MediavisieBv\MarketingApi\Tools\Support;

trait ProfilesTrait
{

    public function getProfileById($id) {
        try {
            if (Support::isUuid($id) === false) {
                throw new \Exception('Invalid id');
            }

            $result = $this->getData('/v1/Profile/Profile/'.$id);
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, ProfileResponse::class);
        } catch (\Exception $e) {
            $data = new ProfileResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }

    public function getProfileByForeignId($id) {
        try {
            $result = $this->getData('/v1/Profile/ProfileByForeignId/'.$id);
            $jm = new JsonMapper();
            $jm->bStrictNullTypes = false;
            $data = $jm->map($result, ProfileResponse::class);
        } catch (\Exception $e) {
            $data = new ProfileResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }

    public function createProfile(Profile $profile) {
        try {
            $result = $this->executeRequest('/v1/Profile/Profile', 'POST', $profile);
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

    public function updateProfile(string $guid, Profile $profile) {
        $result = Support::returnIfNotIsUuid($guid);
        if($result !== null) {
            return $result;
        }

        try {
            $result = $this->executeRequest('/v1/Profile/Profile/'.$guid, 'PUT', $profile);
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