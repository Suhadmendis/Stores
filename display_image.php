<html>
<body>

  
  <?php 
  	if ($_GET["cou"]=="image1"){
		$path="upload/image1/".$_GET["cus_id"];
	}
	
	if ($_GET["cou"]=="image2"){
		$path="upload/image2/".$_GET["cus_id"];
	}
	
	if ($_GET["cou"]=="image3"){
		$path="upload/image3/".$_GET["cus_id"];
	}
	
	if ($_GET["cou"]=="br_copy"){
		$path="upload/br_copy/".$_GET["cus_id"];
	}
	
		$full_path=$path.".jpg";
		
		if (file_exists($full_path)){
			echo "<img src=\"".$full_path."\">";
		} else {
		
			$full_path=$path.".jpeg";
			if (file_exists($full_path)){
				echo "<img src=\"".$full_path."\">";
			} else {
		
				$full_path=$path.".gif";
				if (file_exists($full_path)){
					echo "<img src=\"".$full_path."\">";
				} else {
		
					$full_path=$path.".png";
					if (file_exists($full_path)){
						echo "<img src=\"".$full_path."\">";
					} else {
		
						$full_path=$path.".JPG";
						if (file_exists($full_path)){
							echo "<img src=\"".$full_path."\">";
						} else {
		
							$full_path=$path.".JPEG";
							if (file_exists($full_path)){
								echo "<img src=\"".$full_path."\">";
							} else {
		
								$full_path=$path.".GIF";
								if (file_exists($full_path)){
									echo "<img src=\"".$full_path."\">";
								} else {
		
									$full_path=$path.".PNG";
									if (file_exists($full_path)){
										echo "<img src=\"".$full_path."\">";
									}
								}	
							}
						}
					}
				}
			}					
		}	
	
  ?>

</body>
</html> 