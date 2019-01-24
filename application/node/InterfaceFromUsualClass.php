<?php

class InterfaceFromUsualClass extends InterfaceFromCommonClass implements GeneratorInterface {

    // example: class Animal extends Example implements ExampleInterface
    public function generateInterfaceName($string) {

        $start = strpos($string, "implements");
        if ($start !== false) {
            $length = strpos($string, "{") - $start;
            $string = substr_replace($string, " ", $start, $length);
        }

        $start = strpos($string, "extends");
        if ($start !== false) {
           $this->cutExtends($string);
        }

        $string = str_replace("class", "interface", $string);
        parent::setClassName($string);
        return true;
    }

    public function addFunctionToList($string) {
        parent::addFunctionToList($string);
    }

    private function cutExtends(&$string) {
        $end_pos = strpos($string, "{");
        if ($end_pos === false) {
            $end_pos = strpos($string, "\r\n");
        }
        $start = strpos($string, "extends");
        $string = substr_replace($string, " ", $start, $end_pos-$start);
    }
}