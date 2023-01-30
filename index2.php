<?php 
require 'admin/libs/connect.php';
require 'google-settings.php';

$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

?>

<a href="<?php echo $login_url; ?>" target="_blank">Google ile üye girişi yap</a>

<!-- <?php if(isset($_SESSION['oturum'])){ ?>

<h2>Hoşgeldiniz, <?php echo $_SESSION['isim'];?></h2>
<img src="<?php echo $_SESSION['resim'];?>" width="200" height="200" />
<br>
<a href="logout.php">Çıkış Yap</a>

<?php }else{  ?>
<a href="<?php echo $login_url;?>">GOOGLE İLE ÜYE GİRİŞİ YAP</a>
<?php } ?> -->