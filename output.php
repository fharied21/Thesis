
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Guitar Recommendation</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/one-page-wonder.min.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">Home Page</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        </ul>
      </div>
    </div>
  </nav>
<?php if($maxindex >= 0 && $indexcont>0){?>
<header class="masthead text-center text-black">
  <div class="container pt-3">
        <div class="jumbotron text-center">
            <h1><pre>Your Guitar recommendation is:</pre></h1>
            <?php echo '<img src="data:image/jpeg;base64,'.( $gitar_row[$maxindex]['gambar_gitar'] ).'"/>';?>
            <h1><kbd><?php echo $gitar_row[$maxindex]['nama_gitar']; ?></kbd></h1>
            <h1><kbd><?php echo $gitar_row[$maxindex]['harga_gitar'] ?></kbd></h1>
            
            <a href="<?php echo $gitar_row[$maxindex]['link_detail']?>" class="btn btn-secondary" role="button" target="_blank">Visit</a>
            <a href="start.html" class="btn btn-secondary" role="button">Back</a>
        </div>
    </div>
</header>
<?php }else{?>
  <header class="masthead text-center text-black">
  <div class="container pt-3">
        <div class="jumbotron text-center">
            <h1><pre>No gitar found with your filter</pre></h1>
            <a href="start.html" class="btn btn-secondary" role="button">Back</a>
        </div>
    </div>
</header>
  <?php }?>
<!--   Footer -->
  <footer class="py-5 bg-black">
    <div class="container">
      <p class="m-0 text-center text-white small"></p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
