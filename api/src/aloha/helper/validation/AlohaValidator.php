<?php

namespace Aloha\Helper\Validation;

use Aloha\Exception\DataEmptyException;
use Aloha\Helper\Validation\Message\DefaultValidateMessage;
use Aloha\Utility\Str;

class AlohaValidator
{
    protected $rules = [];

    protected $data = [];

    protected $errors = [];

    protected $fieldNamePropName = "fieldName";

    protected $rulePropName = "rule";

    protected $compareMethodName = "addCompare";

    protected $ruleDemiliter = ":";

    protected $baseClasspath = "Aloha\\Helper\\Validation\\";

    protected $classpath = [];

    protected $passed;

    protected $spliter = " | ";

    /**
     * Construct
     *
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $rules = [], array $data = [], array $classpath = [])
    {
        $this->rules = $rules;
        $this->data = $data;
        $this->classpath = $classpath;
    }

    /**
     * Check giá trị
     *
     * @return void
     */
    public function validate()
    {
        foreach ($this->rules as $field => $ruleProp) {
            $fieldName = $ruleProp[$this->fieldNamePropName] ?? $field;
            $ruleList = $this->getRuleListFromStr($ruleProp[$this->rulePropName]);
            if (!isset($ruleList)) {
                throw new DataEmptyException;
            }
            if (is_array($ruleList)) {
                foreach ($ruleList as $rule) {
                    $this->ruleValidate($field, $rule, $fieldName);
                }
            } else {
                $this->ruleValidate($field, $ruleList, $fieldName);
            }
        }

        $this->passed = empty($this->errors);

        return $this->passed;
    }

    /**
     * Lấy Rule list từ string
     *
     * @param string $ruleStr
     * @return void
     */
    protected function getRuleListFromStr(string $ruleStr)
    {
        return explode($this->spliter, $ruleStr);
    }

    /**
     * Lấy rule class
     *
     * @param string $className
     * @return void
     */
    protected function getClass(string $className)
    {
        $className = Str::ucfirst(Str::before($className, $this->ruleDemiliter));
        $ruleClassName = $this->baseClasspath . "Rule\\" . $className . "Rule";
        $ruleName = $className . "Rule";
        if (!empty($this->classpath)) {
            foreach ($this->classpath as $path) {
                $pathSplit = explode("\\", $path);
                if ($pathSplit[count($pathSplit) - 1] != $ruleName) {
                    continue;
                }
                $ruleClassName = class_exists($path) ? $path : $ruleClassName;
            }
        }
        return $ruleClassName;
    }

    /**
     * Lấy msg class
     *
     * @param string $className
     * @return void
     */
    protected function getValidateMsgClass(string $className)
    {
        $className = Str::ucfirst(Str::before($className, $this->ruleDemiliter));
        $defaultClassName = DefaultValidateMessage::class;
        $ruleClassName = $this->baseClasspath . "Message\\" . $className . "ValidateMessage";
        $ruleName = $className . "Rule";

        $ruleClassName = class_exists($ruleClassName) ? $ruleClassName : $defaultClassName;

        if (!empty($this->classpath)) {
            foreach ($this->classpath as $path) {
                $pathSplit = explode("\\", $path);
                if ($pathSplit[count($pathSplit) - 1] != $ruleName) {
                    continue;
                }
                $msgPath = preg_replace('/Rule\\\/', 'Message\\', $path);
                $msgPath = preg_replace('/(Rule)/', 'ValidateMessage', $msgPath);
                $ruleClassName = class_exists($msgPath) ? $msgPath : $ruleClassName;
            }
        }
        return $ruleClassName;
    }

    /**
     * Lấy data
     *
     * @param string $index
     * @return void
     */
    protected function getDataValue(string $index)
    {
        if (empty($this->data)) {
            throw new DataEmptyException;
        }
        return $this->data[$index] ?? null;
    }

    /**
     * Check giá trị theo Rule
     *
     * @return void
     */
    protected function ruleValidate(string $field, string $rule, string $fieldName)
    {
        // Rule class
        $ruleClass = $this->getClass($rule);
        if (Str::contains($rule, $this->ruleDemiliter)) {
            $compareMethod = $this->compareMethodName;
            $ruleClass::$compareMethod(Str::after($rule, $this->ruleDemiliter));
        }
        if ($ruleClass::validate($field, $this->getDataValue($field))) {
            return;
        }

        // Message class
        $validateMsgClass = $this->getValidateMsgClass($rule);
        $validateMsgClass::$fieldName = $fieldName;
        if (Str::contains($rule, $this->ruleDemiliter)) {
            $compareMsgMethod = $this->compareMethodName;
            $validateMsgClass::$compareMethod(Str::after($rule, $this->ruleDemiliter));
        }

        $currentErrors = isset($this->errors[$field]) ? $this->errors[$field] : [];

        $currentErrors[$rule] = $validateMsgClass::getMsg();

        $this->errors[$field] = $currentErrors;
    }

    /**
     * Thêm rule mới
     *
     * @return void
     */
    public function addRule(string $fieldName, array $ruleProp)
    {
        $this->rules[$fieldName] = $ruleProp;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Thêm class path
     *
     * @return void
     */
    public function addClassPath(string $classpath)
    {
        array_push($this->classpath, $classpath);
    }

    /**
     * Lấy thông tin lỗi sau khi check(dạng đầy đù)
     *
     * @return void
     */
    public function getRawErrors()
    {
        return $this->errors;
    }

    /**
     * Lấy thông tin lỗi sau khi check(dạng rút gọn)
     *
     * @return void
     */
    public function getErrors()
    {
        $fullErrors = $this->errors;
        $errors = [];
        foreach ($fullErrors as $field => $error) {
            $tmpError = [];
            foreach ($error as $rule => $msg) {
                array_push($tmpError, $msg);
            }
            $errors[$field] = $tmpError;
        }
        return $errors;
    }

    /**
     * Validation thành công hay không
     *
     * @return boolean
     */
    public function isPassed()
    {
        return isset($this->passed) ? $this->passed : $this->validate();
    }
}
