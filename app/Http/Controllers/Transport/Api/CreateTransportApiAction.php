<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transport\Api;

use App\Http\Controllers\BaseAction;
use App\Services\Transport\TransportFactory;
use App\Validation\Transport\CreateTransportValidation;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CreateTransportApiAction extends BaseAction
{
    /**
     * @param ResponseFactory $responses
     * @param TransportFactory    $transportFactory
     */
    public function __construct(
        ResponseFactory $responses,
        private TransportFactory $transportFactory
    ) {
        parent::__construct($responses);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validation = new CreateTransportValidation($request->post());

        if ($validation->isFailed()) {
            return $this->responses->json([
                'errors' => $validation->getErrorMessages(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = $this->transportFactory->create(Auth::id(), $validation->getValidated());
        } catch (\Throwable $exception) {
            return $this->responses->json([
                'errors' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->responses->json(['id' => $result]);
    }
}
