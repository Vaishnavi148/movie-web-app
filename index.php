<?php 
	
		$api_key = '3121c578044158767b50c3e4723cef24';
		
		if(isset($_POST['srch-term']) && !empty($_POST['srch-term']) )
		{
			$api_url = 'https://api.themoviedb.org/3/search/movie?api_key='.$api_key.'&language=en-US&page=1&include_adult=false&query='.$_POST['srch-term'];
		}else
		if(isset($_POST['top-rated-movies']) && !empty($_POST['top-rated-movies']) )
		{
			$api_url = 'https://api.themoviedb.org/3/movie/top_rated?api_key='.$api_key.'&language=en-US&page=1';
		}else
		if(isset($_POST['upcoming-movies']) && !empty($_POST['upcoming-movies']) )
		{
			$api_url = 'https://api.themoviedb.org/3/movie/upcoming?api_key='.$api_key.'&language=en-US&page=1';
		}else{
			$_POST['top-rated-movies'] = 'top-rated-movies';
			$api_url = 'https://api.themoviedb.org/3/movie/top_rated?api_key='.$api_key.'&language=en-US&page=1';
		}
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $api_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
			$response_data = json_decode($response, true);
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Movie Data</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<!-- search -->
		<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<form class="navbar-form" role="search" action="index.php" method="post">
			    <div class="input-group add-on col-md-12">
			      <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text" value="<?php echo $_POST['srch-term'] ?>">
			      <div class="input-group-btn">
			        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			      </div>
			    </div>
		  	</form>
	  	</div>
	  	<div class="col-md-1"></div>
	  	</div>
	  	<!-- search end -->
	  	<!-- form start -->
	  	<form class="form" action="index.php" method="post">
		    <div class="col-md-6">
		      <input class="form-control" name="top-rated-movies" id="top-rated-movies" type="hidden" value="top-rated-movies">
		      <div class="input-group-btn">
		        <button class="btn btn-primary btn-block" type="submit">Top Rated Movies</button>
		      </div>
		    </div>
	  	</form>	
	  	<form class="form" action="index.php" method="post">
		    <div class="col-md-6">
		      <input class="form-control" name="upcoming-movies" id="upcoming-movies" type="hidden" value="upcoming-movies">
		      <div class="input-group-btn">
		        <button class="btn btn-primary btn-block" type="submit">Upcoming Movies</button>
		      </div>
		    </div>
	  	</form>
	  	<div class="row">
	  		<?php if(isset($_POST['srch-term']) && !empty($_POST['srch-term']) ){
	  			$search_movies = $response_data['results']; 
	  		 	if(!empty($search_movies)){ ?>
	  			<div>Search Results</div>
	  			<?php  
			 	foreach ($search_movies as $movie) {
			 		echo "Movie Title: ".$movie['title']."<br>";
			 		echo "Overview: ".$movie['overview']."<br>";
			 		echo "Popularity: ".$movie['popularity']."<br><hr>";
			 	} } } ?>
			<?php if(isset($_POST['top-rated-movies']) && !empty($_POST['top-rated-movies']) ){
	  			$top_rated_movies = $response_data['results']; 
	  		 	if(!empty($top_rated_movies)){ ?>
	  			<div>Top Rated Movies</div>
	  			<?php  
			 	foreach ($top_rated_movies as $movie) {
			 		echo "Movie Title: ".$movie['title']."<br>";
			 		echo "Overview: ".$movie['overview']."<br>";
			 		echo "Popularity: ".$movie['popularity']."<br><hr>";
			 	} } } ?>
			<?php if(isset($_POST['upcoming-movies']) && !empty($_POST['upcoming-movies']) ){
	  			$upcoming_movies = $response_data['results']; 
	  		 	if(!empty($upcoming_movies)){ ?>
	  			<div>Upcoming Movies</div>
	  			<?php  
			 	foreach ($upcoming_movies as $movie) {
			 		echo "Movie Title: ".$movie['title']."<br>";
			 		echo "Overview: ".$movie['overview']."<br>";
			 		echo "Popularity: ".$movie['popularity']."<br><hr>";
			 	} } } ?>
	  	</div>	
	  	<!-- form end -->
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>