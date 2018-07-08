<?php
include 'dbConnection.php';

$conn = getDatabaseConnection("ottermart");

function displayCategories() {
    global $conn;
    
    $sql = "Select catID, catName from om_category order by catName";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<a href=\"purchaseHistory.php?productId=".$record["productId"]."\">History</a>";
        echo $record["productName"]. " ". $record["productDescription"] ." $".$record["priceFrom"]."<br><br>";
        echo "<option value ='".$record["catID"]."'>" .$record["catName"]."</option>";
    }
}

function displaySearchResults() {
    global $conn;
    
    if(isset($_GET['searchForm'])) {
        echo "<h3>Products Found: </h3>";
        
        $namedParameters = array();
        
        $sql = "SELECT * FROM om_product WHERE 1";
               
        if(!empty($_GET['product'])){
            $sql .= " AND productName LIKE :productName";
            $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
        }
        
        if(!empty($_GET['category'])){
            $sql .= " AND catID = :categoryID";
            $namedParameters[":categoryID"] =  $_GET['category'];
        }
        
        if(!empty($_GET['priceFrom'])){
            $sql .= " AND price >= :priceFrom";
            $namedParameters[":priceFrom"] = $_GET['priceFrom'] ;
        }
        if(!empty($_GET['priceTo'])){
            $sql .= " AND price <= :priceTo";
            $namedParameters[":priceTo"] =  $_GET['priceTo'] ;
        }
        
         if(!empty($_GET['orderBy'])) {
              if(($_GET['order']=="price")) {
                  $sql .= " ORDER BY price";
              } else {
                  $sql .= " ORDER BY productName";
              }
         }
        

        $stmt = $conn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record) {
            echo  $record["productName"] . " " . $record["productDescription"] . " $" . 
            $record["price"] . "<br><br>";
        } 

        
    }
}

?>

<html>
    <head>
        <title>OtterMart Product Search</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>OtterMart Product Search</h1>
            
            <form>
                Product: <input type="text" name="product"/>
            </br>
            Category:
            <select name="category">
                <option value="">Select One</option>
                <?=displayCategories()?>
            </select>
            </br>
            Price: Form <input type="text" name="priceFrom" size="7"/>
                    To  <input type="text" name="priceTo" size="7"/>
                    <br>
                    Order Result By
                    <br>
                    
                    <input type="radio" name="orderBy" value="price"/>Price<br>
                    <input type="radio" name="orderBy" value="name"/>Name<br>
                    <br><br>

                <input type="submit" value="Search" name="searchForm"/>
            </form>
            </br>
        </div>
        <?=displaySearchResults()?>
    </body>
</html>
