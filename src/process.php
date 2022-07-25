<?php

include("conn.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // echo "post";
    $content = (file_get_contents("php://input"));
    // echo $content;
    $decoded = json_decode($content);
    // echo $decoded->text;
    // echo file_get_contents("php://input");
    // echo json_encode($_POST);

    if ($decoded->type == "add") {

        $prod_name = $decoded->prod_name;
        $prod_cat = $decoded->prod_cat;
        $prod_subcat = $decoded->prod_subcat;
        $prod_color = $decoded->prod_color;
        $prod_price = $decoded->prod_price;

        $sql = <<< EOD
            INSERT INTO products( 
                prod_id,
                prod_name, 
                prod_category,
                prod_sub_category,
                prod_color,
                prod_price
            )
            values(null, 
                :prod_name, 
                :prod_category,
                :prod_sub_category,
                :prod_color,
                :prod_price
            )
            EOD;

        // var_dump($sql);

        //     // $sql = "insert into products ";
        //     // $sql .= "values (null, :prod_name, :category, ";
        //     // $sql .= ":sale_price,  :quantity, ";
        //     // $sql .= "::desc)";

        //     // echo dd($sql);

        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            "prod_name" => $prod_name,
            "prod_category" => $prod_cat,
            "prod_sub_category" => $prod_subcat,
            "prod_color" => $prod_color,
            "prod_price" => $prod_price
        ));

        // echo 11;


        if ($conn->lastInsertId()) {
            echo json_encode(["type" => "add", "status" => "success", "lastId" => $conn->lastInsertId()]);
        } else {
            echo json_encode(["type" => "add", "status" => "error",]);
        }
    } else if ($decoded->type == "search") {
        // echo "saerch";

        $term = $decoded->term;
        $selectedVal = $decoded->selectedVal;

        $sql = <<< EOD
            select 
                * 
            from
                products
            where $selectedVal like '%{$term}%'
        EOD;

        // var_dump($sql);

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    }
}
