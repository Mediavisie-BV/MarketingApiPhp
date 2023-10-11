<?php

namespace MediavisieBv\MarketingApi\Tools;

abstract class Support {
    /**
     * Check if a string is a valid UUID
     * @param string $uid
     * @return bool
     */
    public static function isUuid(string $uid): bool {
        return preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uid) === 1;
    }
}
