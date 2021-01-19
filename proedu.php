<?php
	function search($value='')
	{
		$queryString = http_build_query([
		  'access_key' => 'b33bcf29c53cc7eb7f45705792bb3f59',
		  'query' => $value,
		]);

		$ch = curl_init(sprintf('%s?%s', 'http://api.serpstack.com/search', $queryString));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$json = curl_exec($ch);
		curl_close($ch);
		$api_result = json_decode($json, true);
		return $api_result;
		
	}
	function search_video($value='')
	{
		$queryString = http_build_query([
		  'access_key' => 'b33bcf29c53cc7eb7f45705792bb3f59',
		  'query' => $value,
		  'type' =>'videos'
		]);

		$ch = curl_init(sprintf('%s?%s?%s', 'http://api.serpstack.com/search', $queryString));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$json = curl_exec($ch);
		curl_close($ch);
		$api_result = json_decode($json, true);
		return $api_result;
		
	}
	if (isset($_POST['submit'])) {
		if (strlen($_POST['search']) < 3) {
			$msg = "Pencarian harus lebih dari 3";
			
		}else {
			$data = search($_POST['search']);
			$data2 = search_video($_POST['search']);
		}
	}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Proedu Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/offcanvas/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <a class="navbar-brand mr-auto mr-lg-0" href="#">Proedu.id</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>


    <main role="main" class="container">
    	<br>
    	<?php if(!empty($msg)){?>
    	<div class="alert alert-danger alert-dismissible fade show" role="alert">
      	  <?=$msg?>
		  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
		</div>
	<?php }?>
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">

        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100">Search</h6>
          <br>
          <form class="row g-6" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			  <div class="col-auto">
			    <input type="text" name="search" class="form-control" placeholder="search...">
			  </div>
			  <div class="col-auto">
			    <input type="submit" name="submit" class="btn btn-primary mb-3" value="Search">
			  </div>
			</form>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h6 class="border-bottom border-gray pb-2 mb-0">Recent</h6>
        <?php if(!empty($data)){ 
        	if(empty($data['error'])){
        	foreach ($data['organic_results'] as $number => $result){
	        		if (!empty($result['displayed_url'])) {
        	?>
        <div class="media text-muted pt-3">
          <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><a href="<?=$result['url']?>"><?=$result['title']?></a></strong>
            <br>
            <a href="<?=$result['url']?>"><?=$result['displayed_url']?></a><br>
            <?=$result['snippet']?>
          </p>
        </div>
    <?php 
	} 
	} 
	}else{?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
      	  <?=$data['error']['info']?>
		  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
		</div>
	<?php	}
	}
	?>
      </div>
	 <div class="my-3 p-3 bg-white rounded shadow-sm">
	        <h6 class="border-bottom border-gray pb-2 mb-0">Recent Video</h6>
	        <?php if(!empty($data2)){ 

        	if(empty($data['error'])){
	        	foreach ($data2['video_results'] as $number => $result){
	        		if (!empty($result['displayed_url'])) {
	        	?>
	        <div class="media text-muted pt-3">
	          <img src="<?=$result['displayed_url']?>" >
	          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
	            <strong class="d-block text-gray-dark"><a href="<?=$result['url']?>"><?=$result['title']?></a></strong>
	            <br>
	            <a href="<?=$result['url']?>"><?=$result['displayed_url']?></a><br>
	            <?=$result['uploaded']?>, duration <?=$result['length']?>
	            <br>
	            <?=$result['snippet']?>
	          </p>
	        </div>
	    <?php 
	} 
	} 
		}else{?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
      	  <?=$data['error']['info']?>
		  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
		</div>
		<?php 
	}
	}
		?>
	      </div>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="offcanvas.js"></script>
  </body>
</html>
