<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

        $peso = $_REQUEST['peso'];
        $altura = $_REQUEST['altura'];
        $imc = $peso / ($altura * $altura);

        $resposta = [
            "peso" => $peso,
            "altura" => $altura,
            "imc" => $imc,
        ];

        print(json_encode($resposta));
    ?>
