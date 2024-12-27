<?php

namespace App\Exception;

use Exception;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    private bool $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @param Exception $object
     * @param $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        if ($this->isDebug) {
            $result = [
                'message' => $object->getMessage(),
                'status' => $object->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR,
                'code' => $object->getCode(),
                'trace' => $object->getTrace(),
            ];
        } else {
            if ($object->getStatusCode() && $object->getStatusCode() >= 400 && $object->getStatusCode() <= 499) {
                $result = [
                    'message' => $object->getMessage(),
                    'status' => $object->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR,
                    'code' => $object->getCode(),
                ];
            } else {
                $result = [
                    'message' => 'Internal Server Error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'code' => 0,
                ];
            }
        }

        if (method_exists($object, 'getErrors')) {
            $result['errors'] = $object->getErrors();
        }

        return $result;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FlattenException;
    }
}