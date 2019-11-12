<?php

namespace Mundipagg\Core\Recurrence\Services;

use MundiAPILib\MundiAPIClient;
use Mundipagg\Core\Kernel\Services\APIService;
use Mundipagg\Core\Kernel\Services\LogService;
use Mundipagg\Core\Recurrence\Aggregates\Plan;
use Mundipagg\Core\Recurrence\Factories\PlanFactory;
use Mundipagg\Core\Recurrence\Repositories\PlanRepository;
use Mundipagg\Core\Recurrence\ValueObjects\PlanId;

class PlanService
{
    /** @var LogService  */
    protected $logService;

    public function __construct()
    {
        $this->logService = new LogService(
            'PlanService',
            true
        );
    }

    public function create($postData)
    {
        $planFactory = new PlanFactory();

        $postData['status'] = 'ACTIVE';

        $plan = $planFactory->createFromPostData($postData);
        $planRepository = new PlanRepository();

        $mundipaggPlan = $this->createPlanAtMundipagg($plan);

        $id = new PlanId($mundipaggPlan->id);

        $plan->setMundipaggId($id);

        $planRepository->save($plan);

        return;
    }

    public function createPlanAtMundipagg(Plan $plan)
    {
        $apiService = new APIService();
        $mundipaggApi = $apiService->getMundiPaggApiClient();
        $createPlanRequest = $plan->convertToSdkRequest();
        $planController = $mundipaggApi->getPlans();
        $result = $planController->createPlan($createPlanRequest);

        return $result;
    }

    public function findById($id)
    {
        $productSubscriptionRepository = new PlanRepository();
        return $productSubscriptionRepository->find($id);
    }
}