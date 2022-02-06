<?php
 
  require 'database.php';
if(!empty($_GET['id']))
   {
	   $id= checkInput($_GET['id']);
   };
   
   $db=database::connect();
   $statement=$db->prepare('SELECT items.id,items.name,items.description,items.price,items.image,categories.name as category FROM
					  items LEFT JOIN categories ON items.category=categories.id
					  WHERE items.id = ? ');
   $statement->execute(array($id));
   $item=$statement->fetch();
   database::disconnect();
   
   

   
   function checkInput($data)
   {
	   $data=trim($data);
	   $data=stripslashes($data);
	   $data=htmlspecialchars($data);
	   return $data;
	   
   }


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>king burger </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
	</head>
  <body>
	  <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger code <span class="glyphicon glyphicon-cutlery"></span> </h1>
	  <div class="container admin">
		  <div class="row">
			  <div class="col-sm-6">
				   <h1><strong>voir un item  </strong></h1>
				  <br>
				  <form>
					  <div  class="form-group">
						  <label>NOM:</label> <?php echo '  ' . $item['name']; ?>
					  </div>
					   <div  class="form-group">
						  <label>Description:</label> <?php echo '  ' . $item['description']; ?>
					  </div>
					   <div  class="form-group">
						  <label>Prix:</label> <?php echo '  ' . number_format((float)$item['price'],2,'.','') .' €'; ?>
					  </div>
					   <div  class="form-group">
						  <label>catégorie:</label> <?php echo '  ' . $item['category']; ?>
					  </div>
					   <div  class="form-group">
						  <label>image:</label> <?php echo '  ' . $item['image']; ?>
					  </div>
				  
				  
				  </form>
				  <br>
				  <div class="form-actions">
					  <a class="btn btn-primary" href="index.php" ><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
				  
				  
				  </div>
			  
			  </div>
			   <div class="col-sm-6 site">
							<div class="thumbnail">
								<img src="<?php echo '../image/' . $item['image'];  ?>" alt="...">
								<div class="price"><?php echo   number_format((float)$item['price'],2,'.','') .'€'; ?></div>
								<div class="caption">
									<h4><?php echo  $item['name']; ?></h4>
									<p><?php echo   $item['description']; ?> </p>
									<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>commander</a>
								</div>
					        </div>
		      </div>
			  
			  
			  
			 
			 
		  </div>
	  
	  
	  </div>
	
	
  </body>
</html>
