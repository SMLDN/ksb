<?php

namespace Ksb\Validation\Rule;

use Bootstrap\Interfaces\Helper\RuleInterface;
use Ksb\Model\User;

class PasswordMatchRule implements RuleInterface
{
    protected static $email;

    /**
     * @inheritDoc
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public static function validate($field, $value = null)
    {
        if (empty($value)) {
            return false;
        }
        $user = User::where("email", static::$email)->first();

        if ($user) {
            return password_verify($value, $user->password);
        }

        return false;
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public static function addCompare($email)
    {
        static::$email = $email;
    }
}
