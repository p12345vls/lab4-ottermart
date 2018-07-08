<?php
    include '../dbConnection.php';
    
    echo "from purchaseHistory".$host;
    
    $conn = getDatabaseConnection("ottermart");
    
    $productId = $_GET['productId'];
    
    $sql = "SELECT * FROM om_product NATURAL JOIN om_purchase WHERE productId = :pId";
            
    $np = array();
    $np[":pId"] = $productId;
    
    
    $smt = $conn->prepare($sql);
    $smt->execute($np);
    $records = $smt->fetchAll(PDO::FETCH_ASSOC);
    
    echo $records[0]['productName'] . "<br/>";
    echo "<img src='" . $records[0]['productImage'] . "' width='200'/><br/>";
    
    foreach($records as $record) {
        
        echo "Purchase Date: ". $record["purchaseDate"]."<br>";
        echo "Unit price: ". $record["unitPrice"]."<br>";
        echo "Quantity: ". $record["quantity"]."<br>";
        
    }

 
?>