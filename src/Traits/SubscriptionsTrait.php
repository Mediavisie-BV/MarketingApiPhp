<?php

namespace MediavisieBv\MarketingApi\Traits;

use JsonMapper;
use MediavisieBv\MarketingApi\Models\Responses\SubscriptionsResponse;
use Nette\NotImplementedException;

trait SubscriptionsTrait
{
    public function getSubscriptions()
    {

        try {
            $result = $this->getData('/v1/Subscription/Subscriptions');
            $jm = new JsonMapper();
            $data = $jm->map($result, new SubscriptionsResponse());
        } catch (\Exception $e) {
            $data = new SubscriptionsResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;

    }

    public function getSubscription($id)
    {
       throw new NotImplementedException('Not implemented yet');
    }
}
