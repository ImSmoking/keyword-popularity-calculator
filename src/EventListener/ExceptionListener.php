<?php

namespace App\EventListener;

use App\Exception\BaseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListener
{
    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
    }

    public function __invoke(ExceptionEvent $exceptionEvent): void
    {
        if (!$exceptionEvent->isMainRequest()) {
            return;
        }

        $exception = $exceptionEvent->getThrowable();

        if ($exception instanceof BaseException) {
            $code = $exception->getCode() === 0 ? Response::HTTP_BAD_REQUEST : $exception->getCode();
            $transParameters = $exception->getData();
            $data = [
                'data' => [
                    'message' => $this->translator->trans($exception->getMessage(), $transParameters, 'exceptions')
                ]
            ];

            $exceptionEvent->setResponse(new JsonResponse($data, $code));
        }
    }
}