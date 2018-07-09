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
        echo $record["productName"] . " " . $record["productDescription"] . " $" . $record["priceFrom"] . "<br><br>";
        echo "<option value ='" . $record["catID"] . "'>" . $record["catName"] . "</option>";
    }
}

function displaySearchResults() {
    global $conn;
    echo "<div >";
    if (isset($_GET['searchForm'])) {
        echo "<h3 class='container'>Products Found </h3>";

        $namedParameters = array();

        $sql = "SELECT * FROM om_product WHERE 1";

        if (!empty($_GET['product'])) {
            $sql .= " AND productName LIKE :productName";
            $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
        }

        if (!empty($_GET['category'])) {
            $sql .= " AND catID = :categoryID";
            $namedParameters[":categoryID"] = $_GET['category'];
        }

        if (!empty($_GET['priceFrom'])) {
            $sql .= " AND price >= :priceFrom";
            $namedParameters[":priceFrom"] = $_GET['priceFrom'];
        }
        if (!empty($_GET['priceTo'])) {
            $sql .= " AND price <= :priceTo";
            $namedParameters[":priceTo"] = $_GET['priceTo'];
        }

        if (!empty($_GET['orderBy'])) {
            if (($_GET['orderBy'] == "price")) {
                $sql .= " ORDER BY price";
            } else {
                $sql .= " ORDER BY productName";
            }
        }


        $stmt = $conn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($records as $record) {
            
            echo "<table class='container'>";
            
            echo "<tr><td><a href=\"purchaseHistory.php?productId=" . $record["productId"] . "\">History</a>&nbsp;&nbsp;&nbsp;";
            echo $record["productName"] . " " . $record["productDescription"] . " $" .
            $record["price"] . "</td></tr>";
            
            echo "</table>";
        }
    }
    echo "<div>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>OtterMart Product Search</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lab-5-ottermart/main.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body class="well" >
        <div class="container">
            <h2>OtterMart Product Search</h2>

            <form>
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input type="text" class="form-control" id="usr" name="product">
                </div>
                <div class="form-group">
                    <label for="sel1">Category:</label>
                    <select class="form-control" id="sel1" name="category">
                        <option value="">Select One</option>
                        <?=displayCategories()?>
                    </select>
                </div>

                <label for="From">Price Range:</label>
                <div class="form-check form-control-inline">

                    <input type="text" class="form-control-input"
                           id="From" placeholder=" From" name="priceFrom" size="7">

                    &nbsp;&nbsp; 
                    <input type="text" class="form-control-input"
                           id="to" placeholder=" To" name="priceTo" size="7">
                </div>
                <hr>

                <label>Order Results By:</label>
                <div class="radio">
                    <label><input type="radio" name="orderBy" value="price">Price</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="orderBy" value="name">Name</label>
                </div>
                
                <button type="submit" class="btn btn-primary" value="Search"
                        name="searchForm">Search</button>
                <hr>
            </form>
            </br>
        </div>
        <?=displaySearchResults()?>
    </body>
</html>
