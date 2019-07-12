<?php

namespace Bootstrap\Helper;

class BootstrapValidator
{
    protected $rules = [];

    protected $data = [];

    protected $errors = [];

    protected $fieldNamePropName = "fieldName";

    protected $rulePropName = "rule";

    protected $classPath = [];

    /**
     * Construct
     *
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $data, array $rules = [], array $classPath = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->classPath = $classPath;
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
            $ruleList = $ruleProp[$this->rulePropName] ?? null;
            if (!isset($ruleList)) {
                return true;
            }
            if (is_array($ruleList)) {
                foreach ($ruleList as $rule) {
                    $this->ruleValidate($field, $rule, $fieldName);
                }
            } else {
                $this->ruleValidate($field, $ruleList, $fieldName);
            }
        }

        return empty($this->errors);
    }

    /**
     * Lấy rule class
     *
     * @param string $className
     * @return void
     */
    protected function getClass(string $className)
    {
        $ruleClassName = "Bootstrap\\Helper\\Rule\\" . ucfirst($className) . "Rule";
        if (!empty($this->classPath)) {
            foreach ($this->classPath as $path) {
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
        $defaultClassName = "Bootstrap\\Helper\\Message\\DefaultValidateMessage";
        $ruleClassName = "Bootstrap\\Helper\\Message\\" . ucfirst($className) . "ValidateMessage";

        $ruleClassName = class_exists($ruleClassName) ? $ruleClassName : $defaultClassName;

        if (!empty($this->classPath)) {
            foreach ($this->classPath as $path) {
                $msgPath = preg_replace('/Rule\\\/', 'Message\\', $path);
                $msgPath = preg_replace('/(Rule)/', 'ValidateMessage', $msgPath);
                $msgPath = $msgPath . "ValidateMessage";
                $ruleClassName = class_exists($msgPath) ? $ruleClassName : $ruleClassName;
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
    protected function getData(string $index)
    {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index];
        }
        return null;
    }

    /**
     * Check giá trị theo Rule
     *
     * @return void
     */
    protected function ruleValidate(string $field, string $rule, string $fieldName)
    {
        $ruleClass = $this->getClass($rule);
        if ($ruleClass::validate($field, $this->getData($field))) {
            return;
        }

        $validateMsgClass = $this->getValidateMsgClass($rule);
        $validateMsgClass::$fieldName = $fieldName;

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
     * Lấy thông tin lỗi sau khi check
     *
     * @return void
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
