<?php
   require 'database.php';
$nameerror=$descriptionerror=$priceerror=$categoryerror=$imageerror=$name=$description=$price=$category=$image="";
    
    if(!empty($_POST))
	{
		$name=checkInput($_POST['name']);
		$description=checkInput($_POST['description']);
		$price=checkInput($_POST['price']);
		$category=checkInput($_POST['category']);
		$image=checkInput($_FILES['image']['name']);
		$imagepath='../image' . basename($image);
		$imageExtension=pathinfo($imagepath, PATHINFO_EXTENSION);
		$issuccess=true;
		$isupload=false;
		if(empty($name))
		{
			$nameerror="ce champ ne peut pas etre vide";
			$issuccess=false;
		}
			if(empty($description))
		{
			$descriptionerror="ce champ ne peut pas etre vide";
			$issuccess=false;
		}
			if(empty($price))
		{
			$priceerror="ce champ ne peut pas etre vide";
			$issuccess=false;
		}
			if(empty($category))
		{
			$categoryerror="ce champ ne peut pas etre vide";
			$issuccess=false;
		}
			if(empty($image))
		{
			$imageerror="ce champ ne peut pas etre vide";
			$issuccess=false;
		}
		else
		{
			$isupload=true;
			if($imageExtension != "jpg" && $imageExtension !="png" && $imageExtension != "jpeg" && $imageExtension != "gif")
			{
				$imageerror="les fichier sont autoriser jpg png jpeg gif";
				$isupload=false;
				
			}
			if(file_exists($imagepath))
			{
				$imageerror="le fichier il est existe déja";
				$isupload=false;
			}
			if($_FILES['image']['size'] > 500000)
			{
				$imageerror="le fichier il doit pas depasse 500KB";
			    $isupload=false;
			}
			if($isupload)
			{
				if(!move_uploaded_file($_FILES["image"]["tmp_name"] ,$imagepath))
				{
					$imageerror="il ya eu un error lors de l'upload";
					$isupload=false;
				}
				
			}

		}
		if($isupload && $issuccess)
		{
			$db=database::connect();
			$statment= $db->prepare("INSERT INTO items(name,description,price,category,image) values(?,?,?,?,?)");
			$statment->execute(array($name,$description,$price,$category,$image));
			database::disconnect();
			header("Location:: index.php");
		}
				

		
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
		<title>king burger</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
	</head>
  <body>
	  <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span>king Burger <span class="glyphicon glyphicon-cutlery"></span> </h1>
	  <div class="container admin">
		  <div class="row">
		   <h1><strong> ajouter un item  </strong></h1>
		  <br>
		  <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
			  <div  class="form-group">
				  <label>NOM:</label>
				  <input type="text" class="form-control" name="name" id="name" placeholder="nom" value="<?php echo $name; ?>">
				  <span class="help-inline"><?php echo $nameerror; ?></span>
			  </div>
			   <div  class="form-group">
				  <label>DESCRIPTION:</label>
				  <input type="text" class="form-control" name="description" id="description" placeholder="description" value="<?php echo $description; ?>">
				  <span class="help-inline" ><?php echo $descriptionerror; ?></span>
			  </div>
			   <div  class="form-group">
				   <label for="price">prix: (en €)</label>
				  <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="prix" value="<?php echo $price; ?>">
				  <span class="help-inline"><?php echo $priceerror; ?></span>
				</div>
			   <div  class="form-group">
				  
				   <label for="category">catégorie:</label>
				   <select class="form-control" id="category" name="category">
					   <?php
					   $db=database::connect();
					   foreach($db->query('select * from categories') as $row)
					   {
						   echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
					   }
					   database::disconnect();
				
					   
					   ?>
				  </select>
				   
				
				  <span class="help-inline"><?php echo $categoryerror; ?></span>
				   
			  </div>
			   <div  class="form-group">
				  <label for="image">sélectionner une image</label> 
				   <input type="file" id="image" name="image">
				   <span class="help-inline"><?php echo $imageerror; ?></span>
				   
				   
			  </div>


		 
		  <br>
		  <div class="form-actions">
			  <button  type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span>ajouter</button> 
			  <a class="btn btn-primary" href="index.php" ><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>


		  </div>
		  </form>

	  </div>




  </div>
	  
	  
	  
	
	
  </body>
</html>
