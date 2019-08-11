<?php

namespace Bootstrap\Exception;

use Bootstrap\Helper\Validation\BootstrapValidator;
use Exception;

class ValidationException extends Exception
{
    protected $validator;

    /**
     * Undocumented function
     *
     * @param BootstrapValidator $validator
     */
    public function __construct(BootstrapValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getValidationError()
    {
        return $this->validator->getErrors();
    }
}
