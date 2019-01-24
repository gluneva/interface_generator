<?php

use app\application\core\Controller;


class Controller_Interface extends Controller {

    public function action_index()
    {
        if ($_FILES['file']) {
            $uploaddir =__DIR__.'/../../uploads/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $generator = new GeneratorClass();
                $generator->chooseTypeOfInputClass($uploadfile);
                $generator->generateInterface();
                $generator->writeInterfaceToFile();
                $generator->unloadInterfaceFile();
                exit;
            }else {
                $this->view->generate('interface_generate_view.php', 'template_view.php', array("error" => "Файл не загружен"));
            }


        } else {
            $this->view->generate('interface_generate_view.php', 'template_view.php');
        }

    }
}
?>