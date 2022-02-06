<!DOCTYPE HTML>
<html>
	<head>
		<title>king burger</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
	
	</head>
	<body>
		<div class="container site">
			<h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span>king Burger  <span class="glyphicon glyphicon-cutlery"></span> </h1>
			<?php 
			require 'admin/database.php';
			echo '<nav>
				      <ul class="nav nav-pills" >';

			$db=database::connect();
			$statment= $db->query("SELECT * FROM categories");
			$categories = $statment->fetchAll();
                               
			foreach($categories as $category)
			{
				if($category['id'] == '1')
				{
					echo '<li role="presentation" class="active"><a href="#'  . $category['id'] . '" data-toggle="tab">' .$category['name']. '
					</a></li>';
				}
				else
				{
					echo '<li role="presentation"><a href="#'  . $category['id'] . '" data-toggle="tab">' .$category['name']. '
					</a></li>';
					
				}
	
			}
			echo     '</ul>
			   </nav>';
			echo '<div class="tab-content">';
			
			foreach($categories as $category)
			{
				if($category['id'] == '1')
					echo '<div class="tab-pane active" id="' . $category['id'] . '"> ';
				else
					echo  '<div class="tab-pane" id="' . $category['id'] . '"> ';
				
				echo '<div class="row">';
				
				$statment= $db->prepare("SELECT * FROM items WHERE items.category=?");
			    $statment->execute(array($category['id']));
				
				while($item = $statment->fetch())
				{
					echo '	<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img src="image/' . $item['image'] . '" alt="...">
								<div class="price">' . number_format($item['price'], 2,'.',''). ' €</div>
								<div class="caption">
									<h4>' .$item['name']. '</h4>
									<p>' .$item['description']. ' </p>
									<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>commander</a>
								</div>
					        </div>
						</div>';
					
				}
				echo ' </div>
				  </div>';
			}
			 database::disconnect();
			 echo ' </div>';
			
	
			?>
		
	
		</div>
	
	
	
	 <footer class="text-center" >
		 <a href="#">
			  <span class="glyphicon glyphicon-chevron-up"></span>
		  </a>
		  <h5> Université d'Alger Benyoucef Benkhedda </h5>
	  </footer>

	
	
	</body>
	
</html>
