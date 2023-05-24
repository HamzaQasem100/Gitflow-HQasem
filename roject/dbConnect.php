<?php



class dbConnect {
    public function connect() { 
        $dsn = 'mysql:host=localhost;dbname=URL;' ;
        $user = 'root';
        $password = "";
        try {
            $PDO = new PDO($dsn, $user, $password); 
            $PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $PDO->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
            return $PDO;
        }
        catch(PDOException $e) {
            echo 'Failed '. $e->getMessage();
        }
    }
}


class url {
    
    function __construct() {
        $database = new dbConnect();
        $this->db = $database->connect();
    }

    function create($data) {
        $stmt = $this->db->prepare("INSERT INTO urltable VALUES(:theURL,:Describtion)");
        $stmt->bindParam(":theURL", $data['URL']);
        $stmt->bindParam(":Describtion", $data['Describtion']);
        $stmt->execute();
        return $stmt;
    }
}

$url = new url();
if(isset($_POST['submit'])) 
{ 
    $url = $_POST['URL'];
    $Describtion = $_POST['Describtion'];
    $data = array(
        'URL' => $_POST['URL'],
        'Describtion' => $_POST['Describtion'],
    );
    $url->create($data);
}   

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label class="visually-hidden" for="URL">URL</label>
    <input type="text" class="required form-control" id="URL" name="URL" placeholder="URL" required="required">
    <label class="visually-hidden" for="Describtion">Describtion</label>
    <input type="tel" class="required form-control" id="Describtion" name="Describtion" placeholder="Describtion" required="required">
    <input type="submit" id="submit" name="submit" value="submit">
</form>



</body>
</html>


