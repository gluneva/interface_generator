<?php


class InterfaceFromAbstractClass extends InterfaceFromCommonClass implements GeneratorInterface {

    public $functions_list = [];

    public function generateInterfaceName($string) {

        $string = str_replace("abstract", "",  $string);
        $string = str_replace("class", "interface", $string);
        if (strpos($string, "extends") !== false) {
            $this->cutExtends($string);
        }
        $string = str_replace("implements", "extends", $string);
        parent::setClassName($string);
        return true;
    }

    public function addFunctionToList($string) {
        if (strpos($string, "abstract") !== false) {
            parent::addFunctionToList($string);
        }
    }

    private function cutExtends(&$string) {
        $end_pos = strpos($string, "implements");
        if ($end_pos === false) {
            $end_pos = strpos($string, "{");
        }
        if ($end_pos === false) {
            $end_pos = strpos($string, "\r\n");
        }
        $start = strpos($string, "extends");
        $string = substr_replace($string, " ", $start, $end_pos-$start);

    }
}