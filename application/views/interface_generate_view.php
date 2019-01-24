<h1> Сгенерировать интерфейс </h1>
<?php
if ($data['error']) {
    echo "<div class='error'>".$data['error']."</div>";
}
echo "<form name='generate' action='https://interfacegenerator.dev' method='post' enctype='multipart/form-data'>
<div><label for='dismissal'>Загрузите файл, содержащий класс PHP</label></div>
<div><input  name='file' id='file' type='file'></div>
<div><input name='submit' type='submit' value='Сгенерировать'></div>
</form>";
?>