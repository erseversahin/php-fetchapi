<?php

$db = new PDO('mysql:host=localhost;dbname=fakerphp;', 'root', 'root');

if (isset($_GET['process']) && $_GET['process'] == 'ekle'){

    $post = $_POST;

    if (!$post['name']){
        echo json_encode([
            'title' => 'İşlem Başarız',
            'message' => 'Lütfen adınızı giriniz.',
            'type' => 'error'
        ]);
        exit();
    }
    if (!$post['surname']){
        echo json_encode([
            'title' => 'İşlem Başarız',
            'message' => 'Lütfen soyadınızı giriniz.',
            'type' => 'error'
        ]);
        exit();
    }


    $ins = $db->prepare('INSERT INTO fetchuser SET fetchuser.name =?, fetchuser.surname=?');

    $result = $ins->execute([$post['name'],$post['surname']]);



    if ($result){

        echo json_encode([
            'title' => 'İşlem Başarılı',
            'message' => 'Kişi başarıyla eklendi.',
            'type' => 'success',
            'data' => [
                'id' => $db->lastInsertId(),
                'name' => $post['name'],
                'surname' => $post['surname']
            ]
        ]);
        exit();
    }else{

        echo json_encode([
            'title' => 'İşlem Başarız',
            'message' => 'Kişi eklenirken bir hata meydana geldi.',
            'type' => 'error'
        ]);
        exit();
    }
}


elseif (isset($_GET['process']) && $_GET['process'] == 'sil'){

    $rm = $db->query("DELETE FROM fetchuser WHERE fetchuser.id = {$_POST['id']} ");

    if ($rm){

        echo json_encode([
            'title' => 'İşlem Başarılı',
            'message' => 'Kişi başarıyla silindi.',
            'type' => 'success',
            'data' => [
                'id' => $_POST['id']
            ]
        ]);
        exit();
    }else{

        echo json_encode([
            'title' => 'İşlem Başarız',
            'message' => 'Kişi silinirken bir hata meydana geldi.',
            'type' => 'error'
        ]);
        exit();
    }
}
elseif (isset($_GET['process']) && $_GET['process'] == 'getir'){

    $get = $db->query("SELECT * FROM fetchuser");
    $data = $get->fetchAll(PDO::FETCH_ASSOC);
    if ($data){

        echo json_encode(compact('data'));
        exit();
    }else{

        echo json_encode([
            'title' => 'İşlem Başarız',
            'message' => 'Kişi silinirken bir hata meydana geldi.',
            'type' => 'error'
        ]);
        exit();
    }
}