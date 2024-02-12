<?php

namespace MediavisieBv\MarketingApi\Tools;

use MediavisieBv\MarketingApi\Models\Responses\MessageResponse;

abstract class Support {
    /**
     * Check if a string is a valid UUID
     * @param string $uid
     * @return bool
     */
    public static function isUuid(string $uid): bool {
        return preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uid) === 1;
    }

    public static function returnIfNotIsUuid(string $uid): ?MessageResponse
    {
        if(!self::isUuid($uid)) {
            $data = new MessageResponse();
            $data->error = true;
            $data->message = 'Invalid guid';
            return $data;
        }

        return null;
    }
}
