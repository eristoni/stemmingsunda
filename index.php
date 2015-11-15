<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Stemming Basa SUnda">
<meta name="keywords" content="Stemming Basa Sunda, Bahasa Sunda"/>
<meta name="author" content="Eris Toni">

<title>Stemming Basa Sunda</title>

<!-- Bootstrap -->
<link href="assets/css/bootstrap.css" rel="stylesheet"/>
<link href="assets/cssbootstrap-social.css" rel="stylesheet"/>
<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-default" role="navigation">
    <a href="http://unsri.ac.id" target="_blank"><img src="assets/image/logo_unsri.png" style="width:41px; float:right; margin-right:15px; margin-top:1px;"/></a>
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="http://localhost/stemmingsundakombinasi">Stemming Basa Sunda</a>
      </div>
      <div>
        <form id="form1" name="form1" method="post" action="index.php" enctype="multipart/form-data" class="navbar-form navbar-left" role="form">
          <div class="input-group">
            <?php
            if(isset($_POST['InputKata']))
            {
              echo '<input class="form-control" type="text"  id="InputKata" name="InputKata" placeholder="Masukkan kata yang ingin di-stemm" value=""autofocus/>';
            }
            else
            {
              echo '<input class="form-control" type="text"  id="InputKata" name="InputKata" placeholder="Masukkan kata yang ingin di-stemm" value="" autofocus/>';
            }
            ?>
            <span class="input-group-btn">
               <button class="btn btn-danger" type="submit">Stemm</button>
            </span>
          </div>
          <br><br>
          <div class="input-group">
            <input type="file" id="uploadedfile" name="uploadedfile">
          </div>
          <br>
        </form>
      </div>
    </div>
  </nav>

  <!-- Result -->
  <div class="container">
    <form id="form2" name="form2" method="post" action="">
      <table>
      <td width="400px">
      <label for="input">Hasil Pra-pengolahan</label>

     <textarea class="form-control" name="input"  rows="20" readonly="readonly" id="input"><?php
        include('config.php');
        include('connect.php');
        include('controlstemm.php');
        
        $db = new DB_Connect();
        $controller = new ControlStemm();
        $hasilPreprocessing = "";
        
        if(isset($_POST['InputKata']))
        {   
          if($_POST['InputKata']!='')
          {
            $hasilPreprocessingKata = $controller->doPreprocessing($_POST['InputKata']);
            echo $hasilPreprocessingKata[1];
          }          
        }
        if(isset($_FILES['uploadedfile']['tmp_name']) != null)
        {
          if(file_exists($_FILES['uploadedfile']['tmp_name']))
          {
            $theFile = fopen($_FILES['uploadedfile']['tmp_name'], 'r');
            $hasilPreprocessingFile = $controller->doPreprocessing(fgets($theFile));
            echo $hasilPreprocessingFile[1];
          }
        }
      ?></textarea>
      </td>
      <td width="20px"></td>
      <td width="400">
      <label for="output">Hasil Stemming</label>
      <textarea class="form-control" name="output"  rows="20" readonly="readonly" id="output"><?php
        if(isset($_POST['InputKata']))
        {   
          if($_POST['InputKata']!='')
          {
            $hasilStemmingKata = $controller->doStemming($hasilPreprocessingKata[0]);

            echo $hasilStemmingKata;
          }          
        }

        if(isset($_FILES['uploadedfile']['tmp_name']) != null)
        {
          if(file_exists($_FILES['uploadedfile']['tmp_name']))
          {
            $hasilStemmingFile = $controller->doStemming($hasilPreprocessingFile[0]);

            echo $hasilStemmingFile;
          }
        }
      ?></textarea>
      </td>
      </table>
      </input> 
      
    </form>
  </div>

  <!-- Modal About -->
  <div class="modal fade" id="ModalAbout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel" align="center">About</h4>
        </div>
        <div class="modal-body">
          <center>
            <a href="http://unsri.ac.id" target="_blank"><img src="assets/image/logo_unsri.png" style="width:10%;"/></a>
          </center>
          <br />
          <b>Stemming Bahasa Sunda</b> adalah sistem untuk menghilangkan imbuhan pada suatu kata dalam bahas Sunda.
          <br />
          <br />
          Dikembangkan oleh <b>Eris Toni</b>
          <br />
          Dengan bimbingan :
          <br />
          <ul>
              <li>Rifkie Primartha, M.T.</li>
              <li>Novi Yusliani, M.T.</li>
          </ul>
          Jurusan Teknik Informatika, <a href="http://ilkom.unsri.ac.id" target="_blank"> Fakultas Ilmu Komputer</a> -<a href="http://www.unsri.ac.id" target="_blank"> Universitas Sriwijaya</a>
          <br />
          <br />
          Penghargaan :
          <br />
          Kami ucapkan terimakasih kepada pak danang,dkk karena telah memberikan data penelitiannya.
          <br>
          <a class="btn btn-social-icon btn-xs btn-facebook" href="https://www.facebook.com/eris.toni" target="_blank">
              <i class="fa fa-facebook"></i>
          </a>
          <a class="btn btn-social-icon btn-xs btn-twitter" href="https://twitter.com/eris_toni" target="_blank">
              <i class="fa fa-twitter"></i>
          </a>
          </br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Help -->
  <div class="modal fade" id="ModalHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel" align="center">Bantuan</h4>
        </div>
        <div class="modal-body">
          <ul>
            <li>
              <b>Bagaimana memakai Stemming Basa Sunda?</b>
              <br />
              Cara 1 : <br>- Tulis kata atau kalimat bahasa Sunda pada kolom Stemming Bahasa Sunda. <br>- kemudian klik tombol Stemm.</a>
              <br>Cara 2 : <br>- Klik tombol "Pilih file". <br>- Pilih file dalam format .txt. <br>- kemudian klik tombol Stemm.
            </li>
            <li>
              <b>Masukan apa saja yang dapat diproses?</b>
              <br />
              - Masukan harus dalam bahasa Sunda dengan ejaan kata yang disesuaikan<br>- masukan dapat berupa kata, kalimat, dan file berformat .txt
            </li>
            <li>
              <b>Apa yang dihasilkan dari sistem?</b>
              <br />
              Terdapat 2 kolom yang dihasilkan dalam sistem, yaitu : <br>- Hasil Pra-pengolahan<br>- Hasil Stemming
            </li>
            <li>
              Untuk informasi lebih lanjut dapat menghubungi <a href="mailto:eristoni23@hotmail.com?subject=Saya ingin menanyakan tentang Stemming Bahasa Sunda">eristoni23@hotmail.com</a>. Saya akan merasa senang jika anda dapat membantu saya memperbaiki bugs dengan memberitahu letak error.
            </li>
          </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
      <div class="container-fluid">
          <p class="text-muted">
              <a href="" data-toggle="modal" data-target="#ModalAbout">Tentang</a> ·
              <a href="" data-toggle="modal" data-target="#ModalHelp">Bantuan</a>
              <br />
              Eris Toni &copy 2015
          </p>
      </div>
  </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="assets/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>