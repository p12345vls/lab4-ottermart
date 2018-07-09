<!DOCTYPE html>
<html>
    <head>
        <title>OtterMart Product Search</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="main.css" type="text/css" />

    </head>
</html>

<?php
include 'dbConnection.php';

$conn = getDatabaseConnection("ottermart");

$productId = $_GET['productId'];

$sql = "SELECT * FROM om_product
            NATURAL JOIN om_purchase
            WHERE productId = :pId";

$np = array();
$np[":pId"] = $productId;


$smt = $conn->prepare($sql);
$smt->execute($np);
$records = $smt->fetchAll(PDO::FETCH_ASSOC);



if ($records[0]['productName'] == '') {
    echo "<div class='noRecords'>";
     echo "<a href='index.php'><button>BACK</button></a>";
    echo "<p >" . " &nbsp; &nbsp;&nbsp; &nbsp; No Records" . "</p>";
   echo "<hr>";
    echo "</div>";
} else {

    echo "<div class='history'>";
    echo "<table >";

    echo "<tr><th colspan='4'>" . $records[0]['productName'] . "</th></tr>";

    foreach ($records as $record) {
        echo "<td>" . "Purchase Date: " . $record["purchaseDate"] . "</td>";
        echo "<td>" . "Unit price: " . $record["unitPrice"] . "</td>";
        echo "<td>" . "Quantity: " . $record["quantity"] . "</td>";
    }

    echo "<td>" . "<img src='" . $records[0]['productImage'] . "' width=''/>" . "</td></tr>";


    echo "</table>";

    echo "</div>";
}
?>
