<html>
<head>
  <title>web app sederhana</title>
</head>
<body>
  <?php
  if(!empty($_POST))
  {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    echo 'hallo, ' . $nama;
    echo 'Email : ' . $email;
  }
  ?>
</body>
</html>


