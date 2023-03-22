<?php
session_start();
if ($_POST['submit']) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        if (isset($_FILES['file']['name'])) {
            if ($_FILES['file']['name'] != '') {
                $test = explode(".", $_FILES['file']['name']);
                $extension = end($test);
                while (true) {
                    $name = rand(10000, 100000000) . '.' . $extension;
                    $location = '../../upload/tmp/' . $name;
                    if (!file_exists($name)) {
                        break;
                    }
                }

                copy($_FILES['file']['tmp_name'], $location);
                echo $name;
                $files = glob('../../upload/tmp/*'); // get all file names
                foreach ($files as $file) { // iterate files
                    $req = "../../upload/tmp/$name";
                    if (is_file($file)&&$file!=$req)
                        unlink($file); // delete file
                }
            }
        }
    }
}
