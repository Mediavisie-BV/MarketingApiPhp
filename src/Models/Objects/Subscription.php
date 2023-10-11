<?php

namespace MediavisieBv\MarketingApi\Models\Objects;

class Subscription {
    public string $id;
    public string $name;
    public string $createdAt;
    public ?string $editedAt = null;
    public ?string $deletedAt = null;
}
