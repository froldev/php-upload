<?php
if (!empty($_FILES['files']['name'][0])) {

    $files = $_FILES['files'];

    $uploaded = array();
    $failed = array();

    $allowed = array('png', 'jpg', 'gif');

    foreach($files['name'] as $position => $file_name) {

        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        if(in_array($file_ext, $allowed)) {

            //vérifier les erreurs
            if($file_error === 0) {

                //vérifier le size
                if($file_size <= 1000000) {

                    $file_name_new = uniqid('image', false) . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $uploaded[$position] = $file_destination;
                        header('Location:index.php');
                    } else {
                        $failed[$position] = "[{$file_name}] failed to upload";
                    }

                } else {
                    $failed[$position] = "[{$file_name}] is too large.";
                }

            } else {
                $failed[$position] = "[{$file_name}] errored with code {$file_error}.";
            }

        } else {
            $failed[$position] = "[{$file_name}] file extension '{$file_ext}' in not allowed.";
        }

    }

    // remonter les problemes de l'upload
    if (!empty($uploaded)) {
        print_r($uploaded);
    }

    // remonter les erreurs
    if (!empty($failed)) {
        print_r($failed);
    }

}
