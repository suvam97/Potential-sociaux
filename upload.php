<?php

// code taken from php.net for complete security and to avoid reinventing the wheel


include_once('config/config.php');

header('Content-Type: text/plain; charset=utf-8');

try {

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['fileToUpload']['error']) ||
        is_array($_FILES['fileToUpload']['error'])
    ) {
        $empty = 'There was a problem in uploading this image.';
        header('Location: index.php');
    }

    // Check $_FILES['fileToUpload']['error'] value.
    switch ($_FILES['fileToUpload']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            $empty = 'Please choose a file.';  header('Location: index.php');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
        $empty = 'The file size is too big.';  header('Location: index.php');
        default:
            $empty = 'There was a problem in uploading this image.';
            header('Refresh: 0');
    }

    // You should also check filesize here.
    if ($_FILES['fileToUpload']['size'] > 1000000) {
        $empty = 'The file size is too big.';
        header('Location: index.php');    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES['fileToUpload']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        $empty = 'The file format is invalid.';
        header('Location: index.php');    }



    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    if (!move_uploaded_file(
        $_FILES['fileToUpload']['tmp_name'],
        sprintf('images/%s.%s',
            $_SESSION['user_id'],
            $ext
        )
    )) {
        $empty = 'The file could not be uploaded.';
        header('Location: index.php');    }

    if(isset($empty)) header('Location: index.php');
    header('Location: index.php');

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
