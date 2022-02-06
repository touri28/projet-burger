<?php
   require 'database.php';
if(!empty($_GET['id']))
{
	$id= checkInput($_GET['id']);
}
if(!empty($_POST['id']))
{
	$id= checkInput($_POST['id']);
	$db=database::connect();
    $statment= $db->prepare("DELETE FROM items WHERE id=?");
	$statment->execute(array($id));
	database::disconnect();
	header("Location: index.php");
	
}

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
		<title>burger code</title>
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
		   <h1><strong> supprimer un item  </strong></h1>
		  <br>
		  <form class="form" role="form" action="delete.php" method="post">
			  <input type="hidden" name="id" value="<?php echo $id; ?>">
			  <p class="alert alert-warning">Etes vous sur de vouloir supprimer</p>
		      <div class="form-actions">
			      <button  type="submit" class="btn btn-warning">Oui</button> 
			      <a class="btn btn-default" href="index.php" >Non</a>


		  </div>
		  </form>

	  </div>




  </div>
	  
	  
	  
	
	
  </body>
</html>