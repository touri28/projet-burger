<?php
   require 'database.php';
$nameerror=$descriptionerror=$priceerror=$categoryerror=$imageerror=$name=$description=$price=$category=$image="";

 if(!empty($_GET['id']))
 {
	 $id=checkInput($_GET['id']);
 }
    
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
		
			$isimageupload=false;
		}
		else
		{
			$isimageupload=true;
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
		if(($issuccess && $isimageupload && $isupload) || ($issuccess && !$isimageupload ))
		{
			$db=database::connect();
			if($isimageupload)
			{
			    $statment= $db->prepare("UPDATE items set name= ?,description= ?,price= ?,category= ?,image= ? where id= ?");
			    $statment->execute(array($name,$description,$price,$category,$image,$id));
				
			}
			else
			{
				$statment= $db->prepare("UPDATE items set name= ?,description= ?,price= ?,category= ? where id= ?");
			    $statment->execute(array($name,$description,$price,$category,$id));
				
			}
			
			database::disconnect();
			header("Location: index.php");
		}
		else if($isimageupload &&  !$isupload )
		{
			$db=database::connect();
	        $statment= $db->prepare("SELECT image FROM items WHERE id=?");
	        $statment->execute(array($id));
	        $item  = $statment->fetch();
	        $image          = $item['image'];
			database::disconnect();
			
		}
				

		
	}
else
{
	$db=database::connect();
	$statment= $db->prepare("SELECT * FROM items WHERE id=?");
	$statment->execute(array($id));
	$item  = $statment->fetch();
	$name          = $item['name'];
	$description   = $item['description'];
	$price         = $item['price'];
	$image         = $item['image'];
	$category      = $item['category'];
	database::disconnect();
	
	
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
			  <div class="col-sm-6">
				   <h1><strong> modifier un item  </strong></h1>
		  <br>
		  <form class="form" role="form" action="<?php echo 'modifier.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">
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
						   if($row['id'] == $category)
							   echo '<option selected="selected" value="' . $row['id'] . '" >' . $row['name'] . '</option>';
						   else 
							   echo '<option  value="' . $row['id'] . '" >' . $row['name'] . '</option>';
					   }
					   database::disconnect();
				
					   
					   ?>
				  </select>
				   
				
				  <span class="help-inline"><?php echo $categoryerror; ?></span>
				   
			  </div>
			   <div  class="form-group">
				   <label>image:</label>
				   <p><?php echo $image; ?></p>
				  <label for="image">sélectionner une image</label> 
				   <input type="file" id="image" name="image">
				   <span class="help-inline"><?php echo $imageerror; ?></span>
				   
				   
			  </div>


		 
		  <br>
		  <div class="form-actions">
			  <button  type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span>modifier</button> 
			  <a class="btn btn-primary" href="index.php" ><span class="glyphicon glyphicon-arrow-left"></span> retour</a>


		  </div>
		  </form>

			  
			  
			  </div>
			  <div class="col-sm-6">
				  <div class="thumbnail">
								<img src="<?php echo '../image/' . $image;  ?>" alt="...">
								<div class="price"><?php echo   number_format((float)$price,2,'.','') .'€'; ?></div>
								<div class="caption">
									<h4><?php echo  $name; ?></h4>
									<p><?php echo   $description; ?> </p>
									<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>commander</a>
								</div>
					        </div>
			  
			  
			  </div>
			  
		  
	  </div>




  </div>
	  
	  
	  
	
	
  </body>
</html>