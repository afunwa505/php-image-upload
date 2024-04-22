<?php 
// Include the database configuration file 
include 'connect.php'; 
 
$statusMsg = ''; 
 
// File upload directory 
$targetDir = "images/"; 
 
if(isset($_POST["submit"])){ 
    $id = "";
    if(!empty($_FILES["file"]["name"])){ 
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
     
        // Allow certain file formats 
        $allowTypes = array('JPG','jpg','PNG','JPEG','GIF','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // Upload file to server 
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                // Insert image file name into database 
                $insert = "INSERT INTO images(image) VALUES ('".$fileName."')"; 
                mysqli_query($conn,$insert);
                if($insert){ 
                    $statusMsg = " ".$fileName. " has been uploaded successfully."; 
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            width: 100%;
        }
        a{
            text-decoration: none;
            color: red;
            margin: 5px 0 0 10px;
        }
        a:hover{
            background-color: red;
            color: white;
        }
        p{
            margin: 30px 0 0 10px;
        }
        input{
            margin: 10px 0 0 10px;
        }
        img{
            width: 15%;
            margin: 30px 0 0 40px;   
            border-radius: 7px;    
        }
        img:hover{          
            animation-name: afunwa;
            animation-timing-function: ease-in-out;  
            animation-duration: 4s;
        }
        @keyframes afunwa{
            from{
                transform: scale(1);
            }
            to{
                transform: scale(1.7);
            }
        }
        
    </style>
</head>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <p>Select Image File to Upload:</p>
    <input type="file" name="file"> <br>
    <input type="submit" name="submit" value="Upload">
</form>

<?php
// Include the database configuration file
include 'connect.php'; 

// Get images from the database
$query ="SELECT * FROM images ";
$result = mysqli_query($conn,$query);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $imageURL = 'images/'.$row["image"];
?>
    
    <img src="<?php echo $imageURL; ?>" alt="pic" /><a href="img_delete.php?id=<?php echo $row['id']?>" class="delete">DELETE</a>
    
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } ?>
</body>
</html>