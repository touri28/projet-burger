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
			  <h1><strong>Liste des items  </strong><a href="insert.php?id=1" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
			  <table class="table table-striped table-bordered">
				  <thead>
					  <tr>
						  <th>nom</th>
						  <th>description</th>
					      <th>prix</th>
					      <th>catégorie</th>
						   <th>actions</th>
					   </tr>
				  </thead>
				  <tbody>
					  <?php
					  require "database.php";
					  $db=database::connect();
					  $setment=$db->query('SELECT items.id,items.name,items.description,items.price,categories.name as category FROM
					  items LEFT JOIN categories ON items.category=categories.id
					  ORDER BY items.id DESC');
					  while($item=$setment->fetch())
					  {
						  echo '<tr>';
						  echo '<td>' . $item['name'] . '</td>';
						  echo '<td>' . $item['description'] . '</td>';
						  echo '<td>' . number_format((float)$item['price'],2,'.','') . '</td>';
						  echo '<td>' . $item['category'] . '</td>';
						  echo '<td width=300>';
			 echo '<a class="btn btn-default" href="view.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-eye-open"></span> voir</a>';
						  echo ' ';
			 echo '<a class="btn btn-primary" href="modifier.php?id=' . $item['id']. '"><span class="glyphicon glyphicon-pencil"></span> modifier</a>';
						   echo ' ';
			 echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id']. '"><span class="glyphicon glyphicon-remove"></span> supprimer</a>';
						 echo '</td>';
					  
					     echo '</tr>';
						  
					  }
					   database::disconnect();
					     
					  ?>
					 </tbody>
				 
			  
			  </table>
		  
		  
		  </div>
	  
	  
	  </div>
	
	
  </body>
</html>