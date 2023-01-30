<?php
require 'admin/libs/connect.php';
require 'google-api.php';
require 'google-settings.php';


if(isset($_GET['code'])){

    $gapi = new GooogleLoginApi();
    $data = $gapi->GetAccessToken(CLIENT_ID,CLIENT_REDIRECT_URL,CLIENT_SECRET, $_GET['code']);
    $user = $gapi->GetUserProfileInfo($data['access_token']);
    echo $user['id'];

    // $isim    = $user['name'];
    $username    = $user['name'];
    // $eposta  = $user['email'];
    $email  = $user['email'];
    // $id      = $user['id'];
    $password = md5($user['id']);
    $googleid = $user['id'];
    $image   = $user['picture'];
    // $sifrele = md5($id.$eposta);
   

    $varmi   = $db->prepare("SELECT * FROM users WHERE email=:e AND googleid=:g");
    $varmi->execute([':e' => $eposta,':g'=>$id]);
    if($varmi->rowCount()){

        $guncelle  = $db->prepare("UPDATE users SET username=:i,image=:r WHERE email=:e AND googleid=:g");
        $guncelle->execute([':i' => $username,':r'=>$image,':e'=>$email,':g'=>$googleid]);

    }else{

        $ekle   = $db->prepare("INSERT INTO uyeler SET
            username    =:i,
            email  =:e,
            password   =:s,
            image   =:r,
            password   =:p,
            googleid=:g
        ");

        $ekle->execute([
            ':i'    => $username,
            ':e'    => $email,
            ':s'    => $password,
            ':r'    => $image,
            ':p'    => $password,
            ':g'    => $googleid
        ]);

    }


    
    $_SESSION['email'] = $email;
    $_SESSION['resim']  = $resim;
    header('Location:index.php');

}

?>