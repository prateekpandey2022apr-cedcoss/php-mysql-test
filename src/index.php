<?php include("conn.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h4>Add a new product</h4>

    <form id="add-prod">
        <table>
            <tr>
                <td><label for="prod_name">Name</label></td>
                <td><input type="text" id="prod_name" name="prod_name" required></td>
            </tr>
            <tr>
                <td><label for="prod_cat">Category</label></td>
                <td><input type="text" id="prod_cat" name="prod_cat" required></td>
            </tr>
            <tr>
                <td><label for="prod_subcat">SubCategory</label></td>
                <td><input type="text" id="prod_subcat" name="prod_subcat" required></td>
            </tr>
            <tr>
                <td><label for="prod_color">Color</label></td>
                <td><input type="text" id="prod_color" name="prod_color" required></td>
            </tr>
            <tr>
                <td><label for="prod_price">Price</label></td>
                <td><input type="text" id="prod_price" name="prod_price" required></td>
            </tr>

            <tr>
                <td></td>
                <td><input type="submit"></td>
            </tr>

        </table>
    </form>

    <script>
        let form = document.getElementById("add-prod");

        form.addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(form);
            let jsonBody = Object.fromEntries(formData.entries());
            console.log(jsonBody);

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
                        ...jsonBody,
                        type: "add"
                    })
                })
                .then(response => response.json())
                .then((data) => {
                    console.log(data);
                    alert("Row Inserted Successfully");
                    form.reset();
                })

        })
    </script>


</body>

</html>