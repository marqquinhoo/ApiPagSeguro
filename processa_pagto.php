<?php
    require_once("configPagseguro.php");
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $dadosArray["email"] = EMAIL_PAGSEGURO;
    $dadosArray["token"] = TOKEN_PAGSEGURO;
    $dadosArray["paymentMode"] = "default";
    $dadosArray["paymentMethod"] = $dados['paymentMethod'];
    $dadosArray["receiverEmail"] = $dados['receiverEmail'];
    $dadosArray["currency"] = $dados['currency'];
    $dadosArray["extraAmount"] = $dados['extraAmount'];
    $dadosArray["itemId1"] = $dados['itemId1'];
    $dadosArray["itemDescription1"] = $dados['itemDescription1'];
    $dadosArray["itemAmount1"] = $dados['itemAmount1'];
    $dadosArray["itemQuantity1"] = $dados['itemQuantity1'];
    $dadosArray["notificationURL"] = $dados['notificationURL'];
    $dadosArray["reference"] = $dados['reference'];
    $dadosArray["senderName"] = $dados['senderName'];
    $dadosArray["senderCPF"] = $dados['senderCPF'];
    $dadosArray["senderAreaCode"] = $dados['senderAreaCode'];
    $dadosArray["senderPhone"] = $dados['senderPhone'];
    $dadosArray["senderEmail"] = $dados['senderEmail'];
    $dadosArray["senderHash"] = $dados['senderHash'];
    $dadosArray["shippingAddressRequired"] = $dados['shippingAddressRequired'];
    $dadosArray["shippingAddressStreet"] = $dados['shippingAddressStreet'];
    $dadosArray["shippingAddressNumber"] = $dados['shippingAddressNumber'];
    $dadosArray["shippingAddressComplement"] = $dados['shippingAddressComplement'];
    $dadosArray["shippingAddressDistrict"] = $dados['shippingAddressDistrict'];
    $dadosArray["shippingAddressPostalCode"] = $dados['shippingAddressPostalCode'];
    $dadosArray["shippingAddressCity"] = $dados['shippingAddressCity'];
    $dadosArray["shippingAddressState"] = $dados['shippingAddressState'];
    $dadosArray["shippingAddressCountry"] = $dados['shippingAddressCountry'];
    $dadosArray["shippingType"] = $dados['shippingType'];
    $dadosArray["shippingCost"] = $dados['shippingCost'];
    $dadosArray["creditCardToken"] = $dados['creditCardToken'];
    $dadosArray["installmentQuantity"] = $dados['installmentQuantity'];
    $dadosArray["installmentValue"] = $dados['installmentValue'];
    $dadosArray["noInterestInstallmentQuantity"] = 3;
    $dadosArray["creditCardHolderName"] = $dados['creditCardHolderName'];
    $dadosArray["creditCardHolderCPF"] = $dados['creditCardHolderCPF'];
    $dadosArray["creditCardHolderBirthDate"] = $dados['creditCardHolderBirthDate'];
    $dadosArray["creditCardHolderAreaCode"] = $dados['creditCardHolderAreaCode'];
    $dadosArray["creditCardHolderPhone"] = $dados['creditCardHolderPhone'];
    $dadosArray["billingAddressStreet"] = $dados['billingAddressStreet'];
    $dadosArray["billingAddressNumber"] = $dados['billingAddressNumber'];
    $dadosArray["billingAddressComplement"] = $dados['billingAddressComplement'];
    $dadosArray["billingAddressDistrict"] = $dados['billingAddressDistrict'];
    $dadosArray["billingAddressPostalCode"] = $dados['billingAddressPostalCode'];
    $dadosArray["billingAddressCity"] = $dados['billingAddressCity'];
    $dadosArray["billingAddressState"] = $dados['billingAddressState'];
    $dadosArray["billingAddressCountry"] = $dados['billingAddressCountry'];

    $campos = http_build_query($dadosArray);
    $url = URL_PAGSEGURO."transactions";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $campos);
    $resultado = curl_exec($curl);
    curl_close($curl);

    $xmlPagSeguro = simplexml_load_string($resultado);

    $retorna = ['erro' => true, 'dados' => $xmlPagSeguro];
    header('Content-Type: application/json');
    echo json_encode($retorna);     
?>