<?php

namespace Aloha\Exception;

use Aloha\Helper\Validation\AlohaValidator;
use Exception;

class ValidationException extends Exception
{
    protected $validator;

    /**
     * Construct
     *
     * @param AlohaValidator $validator
     */
    public function __construct(AlohaValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Lấy thông tin validation
     *
     * @return void
     */
    public function getValidationError()
    {
        return $this->validator->getErrors();
    }
}
