<?php


abstract class InterfaceFromCommonClass {

    public $functions_list = [];
    public $className = "";

    public function getFunctionsList() {
        return $this->functions_list;
    }

    public function addFunctionToList($string) {
        $start = strpos($string, "function") + strlen("function");
        $length = strpos($string, "(")- $start;
        $functionName = substr($string, $start, $length);
        $length = strpos($string, ")") - $start;
        $functionName_and_arguments = substr($string, $start, $length+1);

        if (!array_search($functionName, $this->functions_list)) {
            $this->functions_list[$functionName] = $functionName_and_arguments;
        }
    }

    public function setClassName($className) {
        if (strpos($className, "{") === false) {
            $className.= "{\r\n";
        }
        $this->className = $className;

    }

    public function getClassName() {
        return $this->className;
    }
}