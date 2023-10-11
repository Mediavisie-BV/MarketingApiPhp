<?php

namespace MediavisieBv\MarketingApi\Models\Responses;

abstract class BaseResponse {
    public bool $error;
    public ?string $message = null;
}
