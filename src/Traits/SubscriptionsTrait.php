<?php

namespace MediavisieBv\MarketingApi\Traits;

use JsonMapper;
use MediavisieBv\MarketingApi\Models\Responses\SubscriptionResponse;
use MediavisieBv\MarketingApi\Models\Responses\SubscriptionsResponse;
use MediavisieBv\MarketingApi\Tools\Support;

trait SubscriptionsTrait
{
    /**
     * @return mixed|object|string
     */
    public function getSubscriptions(): mixed
    {

        try {
            $result = $this->getData('/v1/Subscription/Subscriptions');
            if ($result->data === null) {
                throw new \Exception('No subscriptions found');
            }
            $jm = new JsonMapper();
            $data = $jm->map($result, SubscriptionsResponse::class);
        } catch (\Exception $e) {
            $data = SubscriptionsResponse::class;
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;

    }

    /**
     * @param $id
     * @return \MediavisieBv\MarketingApi\Models\Responses\SubscriptionResponse|mixed|object|string
     */
    public function getSubscription($id): mixed
    {
        try {
            // check if the given id is an uuid
            if (Support::isUuid($id) === false) {
                throw new \Exception('Invalid id');
            }

            $result = $this->getData('/v1/Subscription/Subscription/' . $id);
            if ($result->data === null) {
                throw new \Exception('Subscription not found');
            }
            $jm = new JsonMapper();
            $data = $jm->map($result, new SubscriptionResponse());
        } catch (\Exception $e) {
            $data = new SubscriptionResponse();
            $data->error = true;
            $data->message = $e->getMessage();
        }

        return $data;
    }
}
