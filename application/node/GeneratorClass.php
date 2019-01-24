<?php


class GeneratorClass {

    public $fileName = "";
    public $int_fileName = "";
    public $interface_obj = null;

    public function chooseTypeOfInputClass($uploadFile)
    {
        $this->fileName = $uploadFile;
        $path_parts = pathinfo($uploadFile);
        $this->int_fileName = __DIR__ .'/../../uploads/' . $path_parts['filename'] . 'Interface.' . $path_parts['extension'];

        if (file_exists($this->fileName) && is_readable($this->fileName)) {
            $f_data = file_get_contents($this->fileName);
            $f_data_array = explode("\r\n", $f_data);
            $this->interface_obj = new InterfaceFromUsualClass();
            foreach($f_data_array as $string) {
                if (preg_match("/^abstract class/", $string) !== 0) {
                    $this->interface_obj = new InterfaceFromAbstractClass();
                }
            }
        }
    }

    public function generateInterface() {
        if (file_exists($this->fileName) && is_readable($this->fileName)){
            $fc = @fopen($this->fileName, 'r');
            if ($fc) {
                while(!feof($fc)) {
                    $s = fgets($fc);
                    if(preg_match("/^class/", $s) !== 0 || preg_match("/^abstract class/", $s) !== 0 ) {
                        if($this->interface_obj instanceof GeneratorInterface) {
                            $s = $this->interface_obj->generateInterfaceName($s);
                        }
                    }
                    if (preg_match("/[\s](public|protected|private) function/", $s) !== 0 && strpos($s, "__construct") === false) {
                        if ($this->interface_obj instanceof GeneratorInterface) {
                            $this->interface_obj->addFunctionToList($s);
                        }
                    }
                }

                fclose($fc);
                unlink($this->fileName);
                return true;
            }
        }
        return false;
    }

    public function writeInterfaceToFile() {
        $fi = @fopen($this->int_fileName, 'w');
        if ($fi) {
            fwrite($fi, "<?php\r\n");
            fwrite($fi, $this->interface_obj->getClassName());

            if (count($this->interface_obj->getFunctionsList())) {
                $functions = $this->interface_obj->getFunctionsList();
                foreach($functions as $key => $value) {
                    $string = "public function " . $value .";\r\n";
                    fwrite($fi, $string);
                }
            }
            fwrite($fi, "}");
            fclose($fi);
        }
    }

    public function unloadInterfaceFile() {
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: text/php');
        header('Content-Disposition: attachment; filename=' . basename($this->int_fileName));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->int_fileName));
        // читаем файл и отправляем его пользователю
        readfile($this->int_fileName);
        unlink($this->int_fileName);
        exit;
    }

}