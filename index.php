<?php

require 'vendor/autoload.php';

$app = new App;
$app->db = new DB; 
$app->queue = new Queue; 


function delete_folder($folder) {
    $glob = glob($folder);
    foreach ($glob as $g) {
        if (!is_dir($g)) {
            unlink($g);
        } else {
            delete_folder("$g/*");
            rmdir($g);
        }
    }
}

$app->get('/', function () use ($app) {
    $files = $app->db->from('uploads');
    $app->render('app.php', compact('files'));
});

$app->get('/delete/:id', function ($id) use ($app) {
    $file = $app->db->from('uploads')->where('id', $id)->fetch();
    $dir =  dirname(getcwd() . $file['path']);
    delete_folder($dir);
    $files = $app->db->deleteFrom('uploads')->where('id', $id)->execute();
    $app->redirect('/');
});

$app->post('/', function() use ($app){
    $file = $_FILES['file'];
    $dir = '/uploads/' . uniqid();
    $path = $dir . '/' . $file['name'];
    mkdir(getcwd() . $dir);
    move_uploaded_file($file['tmp_name'], getcwd() . $path);
    $app->db->insertInto('uploads')->values([
        'name' => $file['name'],
        'path' => $path,
        'size' => $file['size'],
    ])->execute();
    $app->queue->send('pdf', getcwd() . $path, 'all');
    $app->redirect('/');
});

//  run the app
$app->run();