<?php

    //Necessário possuir SSL
    define("URL","ENDERECO_DO_SEU_SITE");

    $sandbox = true;
    if($sandbox){
        define("EMAIL_PAGSEGURO", "SEU_EMAIL_PAG_SEGURO");
        define("TOKEN_PAGSEGURO", "TOKEN_SANDBOX_PAGSEGURO");
        define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
        define("SCRIPT_PAGSEGURO", "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
        define("EMAIL_LOJA", "EMAIL_PAG_SEGURO");
        define("MOEDA_PAGAMENTO", "BRL");
        define("URL_NOTIFICACAO", "URL_ONDE_SERA_ENVIADO_O_RETORNO_NO_SEU_SITE");
    }else{
        define("EMAIL_PAGSEGURO", "SEU_EMAIL_PAG_SEGURO");
        define("TOKEN_PAGSEGURO", "TOKEN_SANDBOX_PAGSEGURO");
        define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
        define("SCRIPT_PAGSEGURO", "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
        define("EMAIL_LOJA", "EMAIL_PAG_SEGURO");
        define("MOEDA_PAGAMENTO", "BRL");
        define("URL_NOTIFICACAO", "URL_ONDE_SERA_ENVIADO_O_RETORNO_NO_SEU_SITE");
    }

?>
