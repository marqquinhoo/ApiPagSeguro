
pagamento();

function pagamento(){
    var endereco = jQuery('.endereco').attr("data-endereco");
    $.ajax({
        url : endereco + "pagamento.php",
        type : 'POST',
        dataType: 'json',
        beforeSend: function () {
            bloquearTela();
        },
        success : function(retorno){
            PagSeguroDirectPayment.setSessionId(retorno.id);
        },
        complete : function (retorno){            
            listarMeioPag();
        }
    });
}



function listarMeioPag(){
    var amount = document.getElementById('amount').value;

    PagSeguroDirectPayment.getPaymentMethods({
        amount: amount,
        success: function(retorno) {
            // console.log(retorno);
            $('.meio-pag').append("<div style='margin-top:1em'><strong>Cartões de Crédito Aceitos</strong></div>");
            
            $.each(retorno.paymentMethods.CREDIT_CARD.options, function(i, obj){         
                $('.meio-pag').append("<span class='img-bandeira'><img src='https://stc.pagseguro.uol.com.br"+obj.images.MEDIUM.path+"'/></span></div>");
            });


            $('.meio-pag').append("<div style='margin-top:1em'><strong>Boleto</strong></div>");
            $.each(retorno.paymentMethods.BOLETO.options, function(i, obj){             
                $('.meio-pag').append("<span class='img-bandeira'><img src='https://stc.pagseguro.uol.com.br"+obj.images.MEDIUM.path+"'/></span>");
            });
        },
        error: function(retorno) {
            // Callback para chamadas que falharam.
        },
        complete: function(c) {
            desbloquearTela();
        }
    });
}

function obtemParcelamento(imgBand){
    var amount = document.getElementById('amount').value;

    PagSeguroDirectPayment.getInstallments({
        amount: amount,
        maxInstallmentNoInterest: 3,
        brand: imgBand,
        success: function(retorno){
       	    $.each(retorno.installments, function(i, obja){
                var ic = 0;
                $.each(obja, function(i, objb){
                    ic++;
                    if(ic <= 3){
                        var msg = " - Sem juros";
                    }else{
                        var msg = " - Com juros";
                    }
                    var valorParcela = objb.installmentAmount.toFixed(2).replace(".",",");
                    $('#installmentQuantity').show().append("<option value='"+objb.quantity+"' data-parcelas='"+objb.installmentAmount+"'>"+objb.quantity+" parcelas de R$"+valorParcela+" "+msg+"</option>");
                    $('#validade').show();
                    $('#mes').show();
                    $('#ano').show();
                    $('#cvvLabel').show();
                    $('#cvv').show();
                    $('#nomeComprador').show();
                    $('#creditCardHolderName').show();
                    $('#senderName').show();
                    $('#btnComprar').show();
                    $('#vlParcelas').show();
                    $('#installmentValue').show();
                    $('#lblCpf').show();
                    $('#creditCardHolderCPF').show();
                });
            });            
       },
        error: function(retorno) {
       	    // callback para chamadas que falharam.
       },
        complete: function(retorno){
            // Callback para todas chamadas.
       }
});
}

$('#nCartao').on('keyup', function() {
    var nCartao = $(this).val();
    var qntNumero = nCartao.length;
    $('#msg').empty();
    
    if(qntNumero == 6){
        PagSeguroDirectPayment.getBrand({
            cardBin: nCartao,
            success: function(retorno) {
              var imgBand = retorno.brand.name;
              $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/"+imgBand+".png'/>");
              $('#imgBand').val(imgBand);
              obtemParcelamento(imgBand);
            },
            error: function(retorno) {
                $('.bandeira-cartao').empty();
                $('#msg').html("<div class='alert alert-danger' role='alert'>Cartão Inválido!</div>");
            },
            complete: function(retorno) {

            }
        });
    }    
});

$('#cvv').on('keyup', function() {  
    var cvv = $(this).val();
    var qntNumero = cvv.length;  
    if(qntNumero == 3){
        getTokenCartao();
    }    
});

$('#installmentQuantity').change(function(){
   $('#installmentValue').val($('#installmentQuantity').find(':selected').attr('data-parcelas'));
});

function getTokenCartao(){

    var nCartao = document.getElementById('nCartao').value;
    var imgBand = document.getElementById('imgBand').value;
    var cvv = document.getElementById('cvv').value;
    var mes = document.getElementById('mes').value;
    var ano = document.getElementById('ano').value;

    PagSeguroDirectPayment.createCardToken({
        cardNumber: nCartao, // Número do cartão de crédito
        brand: imgBand, // Bandeira do cartão
        cvv: cvv, // CVV do cartão
        expirationMonth: mes, // Mês da expiração do cartão
        expirationYear: ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
        success: function(retorno) {
            $('#creditCardToken').val(retorno.card.token);
        },
        error: function(retorno) {
                 // Callback para chamadas que falharam.
        },
        complete: function(retorno) {
             // Callback para todas chamadas.
        }
     });
}

$('#formPagamento').on("submit", function(event){
    event.preventDefault();
    
    PagSeguroDirectPayment.onSenderHashReady(function(retorno){
        if(retorno.status == 'error'){
            console.log(retorno.message);
            return false;
        }else{
            $('#senderHash').val(retorno.senderHash);
            var dados = $('#formPagamento').serialize();

            var endereco = jQuery('.endereco').attr("data-endereco");

            // console.log(endereco);

            $.ajax({
                method: "POST",
                url : endereco + "processa_pagto.php",
                data : dados,
                beforeSend: function () {
                    bloquearTela();
                },
                dataType : 'json',
                success : function(retorna){
                    console.log("Sucesso "+ JSON.stringify(retorna));
                },
                error : function(retorna){
                    console.log("Erro"+ retorna);
                },
                complete : function(){            
                    desbloquearTela();
                }
            });
        }        
    });

});




