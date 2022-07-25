<?php

include("conn.php");


// sql to count all the rows
$sql = <<<EOD
    SELECT 
        *
	 from 
    products    
EOD;

$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($rows);
// echo "</pre>";

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

    <form id="search-form">
        <input type="text" name="search" id="search" placeholder="Search here">
        <select id="column">
            <option></option>
            <option value="prod_name">Product Name</option>
            <option value="prod_category">Product Category</option>
            <option value="prod_sub_category">Product Sub Category</option>
            <option value="prod_sub_category">Product Sub Category</option>
            <option value="prod_color">Product Color</option>
            <option value="prod_price">Product Price</option>
        </select>

        <input type="submit">
    </form>

    <table>
        <tr>
            <td>id</td>
            <td>Name</td>
            <td>Category</td>
            <td>Sub Category</td>
            <td>Color</td>
            <td>Price</td>
        </tr>


        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?php echo $row['prod_id'] ?></td>
                <td><?php echo $row['prod_name'] ?></td>
                <td><?php echo $row['prod_category'] ?></td>
                <td><?php echo $row['prod_sub_category'] ?></td>
                <td><?php echo $row['prod_color'] ?></td>
                <td><?php echo $row['prod_price'] ?></td>
            </tr>
        <?php endforeach; ?>


    </table>


    <script>
        const form = document.getElementById("search-form");

        form.addEventListener("submit", function(event) {
            event.preventDefault();

            const term = document.getElementById("search").value
            const select = document.getElementById("column");
            const selectedVal = select.options[select.selectedIndex].value;
            console.log(selectedVal);
            console.log(term);

            fetch("/process.php", {
                    method: "POST",
                    // mode: "same-origin",
                    // credentials: "same-origin",
                    // headers: {
                    //     "Content-type": "application/json; charset=UTF-8"
                    // },
                    headers: {
                        // "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"                
                    },
                    body: JSON.stringify({
                        term: term,
                        selectedVal: selectedVal,
                        type: "search"
                    })
                })
                .then(response => response.json())
                .then((data) => {
                    console.log(data);
                    if (data["type"] == "add") {
                        alert("Row Inserted Successfully");
                    } else {
                        console.log(data);
                    }

                    form.reset();
                })


        });
    </script>


</body>

</html>