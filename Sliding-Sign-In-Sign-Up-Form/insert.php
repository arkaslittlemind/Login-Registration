<?php
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $dbname = "registration"; 

    if(!empty($Username) || !empty($Email) || !empty($Password)){
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "registration";

        // Create connection
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
        if(mysqli_connect_error()){
            die('Connect Error('.mysqli_connect_errno().')' .mysqli_connect_error());
        } else {
            $SELECT = "SELECT email from registration Where email = ? Limit 1";
            $INSERT = "INSERT Into registration (username, email, password) values(?, ?, ?)";

            //Prepare Statement
            $statement = $conn->prepare($SELECT);
            $statement -> bind_param("s", $email);
            $statement -> execute();
            $statement -> bind_result($email);
            $statement -> store_result();
            $rnum = $statement->num_rows;

            if($rnum == 0){
                $statement -> close();
                $statement = $conn->prepare($INSERT);
                $statement -> bind_param("sss", $Username,$Email,$Password);
                $statement -> execute();
                echo "New Record inserted sucessfully";
            } else {
                echo "Email already registered";
            }
            $statement -> close();
            $conn -> close();
        }
} else {
    echo "All fields are required";
    die();
} 
?>