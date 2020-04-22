<?php
  require_once("configPagseguro.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <link href="css/jquery-ui.css" rel="stylesheet" />

    <script src="<?php echo SCRIPT_PAGSEGURO;?>"></script>
 
    <title>Api Pagamento PagSeguro</title>
  </head>
  <body >

    <div class="container" >
        <div class="row col-md-12" style="min-height:550px; margin:15px auto; background-color:#eaffff">
            <!-- <button onclick="pagamento()" class="btn btn-primary">Pagar</button> -->
            <span class="endereco" data-endereco="<?php echo URL;?>"></span>
            <span id="msg"></span>
            
              <form action="" name="formPagamento" name="formPagamento" id="formPagamento">
                  <input type="hidden" name="paymentMode" id="paymentMode" value="default" />
                  <input type="hidden" name="paymentMethod" id="paymentMethod" value="creditCard" />
                  <input type="hidden" name="receiverEmail" id="receiverEmail" value="<?php echo EMAIL_LOJA;?>" />
                  <input type="hidden" name="currency" id="currency" value="<?php echo MOEDA_PAGAMENTO;?>" />
                  <input type="hidden" name="extraAmount" id="extraAmount" value="" />
                  <input type="hidden" name="itemId1" id="itemId1" value="0001" />
                  <input type="hidden" name="itemDescription1" id="itemDescription1" value="Protese 36 Velocidades" />
                  <input type="hidden" name="itemAmount1" id="itemAmount1" value="600.00" />
                  <input type="hidden" name="itemQuantity1" id="itemQuantity1" value="1"/>
                  <input type="hidden" name="notificationURL" id="notificationURL" value="<?php echo URL_NOTIFICACAO;?>" />
                  <input type="hidden" name="reference" id="reference" value="1001" /> 

                  <div class="col-md-5" style="border:1px solid #c0c0c0; float:left; border-radius:10px; margin-right:5px;">
                      <label><strong>Valor de Sua Compra</strong></label>
                      <!--Colocar o valor total do pedido aqui-->
                      <div class="row col-md-12">
                        <div class="col-md-8"><input type="text" name="amount" id="amount" value="600.00" class="form-control co-md-4"/></div>                  
                      </div>

                      <label><strong>Número do Cartão</strong></bold:></label>
                      <div class="row col-md-12">
                        <div class="col-md-8"><input type="text" name="nCartao" id="nCartao" maxlength="16" class="form-control" autocomplete="off"/></div>
                        <div class="col-md-4"><div class="bandeira-cartao"></div>
                        <input type="hidden" name="imgBand" id="imgBand" value=""/>               
                        <input type="hidden" name="creditCardToken" id="creditCardToken" value=""/>
                        <input type="hidden" name="senderHash" id="hashCartao" value=""/>
                        </div>                  
                      </div>
                      

                      <select type="text" name="installmentQuantity" id="installmentQuantity" class="qtdeParcelas form-control">
                        <option value="">Selecione o Numero de Parcelas</option>
                      </select>

                      <label class="vlParcelas" id="vlParcelas"><strong>Valor das Parcelas</strong></label>
                      <p><input type="text" name="installmentValue" id="installmentValue" value="" class="valorParcelas form-control"/></p>

                      <label class="validade" id="validade"><strong>Validade</strong></label>
                      <p><select type="text" name="mes" id="mes" class="validade form-control col-md-4">
                          <option value="">Selecione</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                        </select>

                        <select type="text" name="ano" id="ano" class="validade form-control col-md-4">
                          <option value="">Selecione</option>
                          <option value="<?php echo date("Y");?>"><?php echo date("Y");?></option>
                          <?php
                            $anoAtualm1 = date("Y");
                            $proximo = 0;
                            for($i=1;$i <= 10;$i++){                          
                              $anoAtualm1++;
                          ?>
                              <option value="<?php echo $anoAtualm1;?>"><?php echo $anoAtualm1;?></option>
                          <?php }?>
                        </select>
                        </p>

                        <label class="cvvLabel" id="cvvLabel"><strong>CVV</strong></label>
                        <p><input type="text" name="cvv" id="cvv" value="" maxlength="3" class="col-md-2 form-control cvv" autocomplete="off"/></p>

                        <label class="nomeComprador" id="nomeComprador"><strong>Nome Impresso no Cartão</strong></label>
                        <p><input type="text" name="creditCardHolderName" id="creditCardHolderName" value="Jose Comprador" class="nomeComp form-control"/></p>

                        <label class="lblCpf" id="lblCpf"><strong>CPF do Titular do Cartão</strong></label>
                        <p><input type="text" name="creditCardHolderCPF" id="creditCardHolderCPF" value="22111944785" class="cpfTitCard form-control"/></p>
                        
                        <div class="row">
                            <div class="meio-pag"></div>
                        </div>
                        
                        
                    </div>

                    <div class="col-md-6" style="border:1px solid #c0c0c0; float:left; border-radius:10px;">

                        <div class="row">  
                          <strong>Endereço do Titular do Cartão</strong>
                        </div>
                         
                        <div class="row">
                          <div class="col-md-8">
                              <input type="text" name="billingAddressStreet" id="billingAddressStreet" value="Av Joao Naves de Avila" placeholder="Endereco" maxlength="100" class="form-control" autocomplete="off"/>
                          </div> 
                          <div class="col-md-4">
                              <input type="text" name="billingAddressNumber" id="billingAddressNumber" value="12345" maxlength="15" placeholder="Numero" class="form-control" autocomplete="off"/>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4">
                              <input type="text" name="billingAddressComplement" id="billingAddressComplement" value="Casa" maxlength="60" class="form-control" autocomplete="off"/>
                          </div>
                          <div class="col-md-8">
                              <input type="text" name="billingAddressDistrict" id="billingAddressDistrict" value="Centro" maxlength="30" placeholder="Bairro" class="form-control" autocomplete="off"/>
                          </div> 
                        </div>

                        <div class="row">                         
                          <div class="col-md-4">
                            <input type="text" name="billingAddressPostalCode" id="billingAddressPostalCode" value="38400000" maxlength="9" class="form-control" autocomplete="off"/>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="billingAddressCity" id="billingAddressCity" value="Uberlandia" maxlength="60" class="form-control" autocomplete="off"/>
                          </div>
                        </div>

                        <div class="row">                         
                          <div class="col-md-4">
                            <input type="text" name="billingAddressState" id="billingAddressState" value="MG" maxlength="9" class="form-control" autocomplete="off"/>
                          </div>
                        </div>
                        <input type="hidden" name="billingAddressCountry" id="billingAddressCountry" value="BRL">

                        <div class="row">  
                          <strong>Dados do Comprador:</strong>
                        </div>

                        <div class="row">
                          <div class="col-md-8">
                              <input type="text" name="senderName" id="senderName" value="Maria Compradora" maxlength="60" placeholder="Nome Comprador" class="form-control" autocomplete="off"/>
                          </div>       
                          <div class="col-md-4">
                          <input type="text" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" value="01/01/2002" maxlength="10" placeholder="01/01/2002" class="form-control" autocomplete="off"/>
                          </div>                    
                        </div>

                        <div class="row">
                          <div class="col-md-4">
                              <input type="text" name="senderCPF" id="senderCPF" value="93224762063" maxlength="15" placeholder="CPF Comprador" class="form-control" autocomplete="off"/>
                          </div>       
                          <div class="col-md-4">
                            <input type="text" name="senderAreaCode" id="senderAreaCode" value="34" maxlength="2" placeholder="34" class="form-control" autocomplete="off"/>
                          </div>
                          <div class="col-md-4">
                            <input type="text" name="senderPhone" id="senderPhone" value="999999999" maxlength="9" placeholder="999999999" class="form-control" autocomplete="off"/>
                          </div>                    
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                              <input type="text" name="senderEmail" id="senderEmail" value="maria@sandbox.pagseguro.com.br" maxlength="120" class="form-control" autocomplete="off"/>
                          </div>                    
                        </div>

                        <div class="row">  
                          <strong>Endereço de Entrega:</strong>
                        </div>

                        <input type="hidden" name="shippingAddressRequired" id="shippingAddressRequired" value="true" maxlength=""/>
                        <div class="row">
                          <div class="col-md-8">
                              <input type="text" name="shippingAddressStreet" id="shippingAddressStreet" value="Av Joao Naves de Avila" placeholder="Endereco" maxlength="100" class="form-control" autocomplete="off"/>
                          </div> 
                          <div class="col-md-4">
                              <input type="text" name="shippingAddressNumber" id="shippingAddressNumber" value="12345" maxlength="15" placeholder="Numero" class="form-control" autocomplete="off"/>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4">
                              <input type="text" name="shippingAddressComplement" id="shippingAddressComplement" value="Casa" maxlength="60" class="form-control" autocomplete="off"/>
                          </div>
                          <div class="col-md-8">
                              <input type="text" name="shippingAddressDistrict" id="shippingAddressDistrict" value="Centro" maxlength="30" placeholder="Bairro" class="form-control" autocomplete="off"/>
                          </div> 
                        </div>

                        <div class="row">                         
                          <div class="col-md-4">
                            <input type="text" name="shippingAddressPostalCode" id="shippingAddressPostalCode" value="38400000" maxlength="9" class="form-control" autocomplete="off"/>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="shippingAddressCity" id="shippingAddressCity" value="Uberlandia" maxlength="60" class="form-control" autocomplete="off"/>
                          </div>
                        </div>

                        <div class="row">                         
                          <div class="col-md-4">
                            <input type="text" name="shippingAddressState" id="shippingAddressState" value="MG" maxlength="9" class="form-control" autocomplete="off"/>
                          </div>
                        </div>

                        <input type="hidden" name="shippingAddressCountry" id="shippingAddressCountry" value="BRL">

                        <div class="row">
                          <div class="col-md-12"><strong>Tipo de Entrega:</strong>
                              <input type="radio" name="shippingType" value="1"/>PAC
                              <input type="radio" name="shippingType" value="2"/>SEDEX
                              <input type="radio" name="shippingType" value="3" checked="checked"/>FRETE GRATIS
                          </div>  
                        </div>

                        <div class="row">
                          <div class="col-md-4">
                            <strong>Valor da Entrega:</strong>
                          </div>  
                          <div class="col-md-8">
                            <input type="text" name="shippingCost" id="shippingCost" value="0.00" maxlength="50" class="form-control" autocomplete="off"/>
                          </div>                  
                        </div>

                        <div class="row">  
                          <div class="col-md-12">
                          <button type="submit" name="btnComprar" id="btnComprar" class="btn btnComprar btn-primary">Finalizar Compra</button>
                          </div>                   
                        </div>

                        <div class="row">&nbsp;</div>
                        
                    </div>
              </form>
            
            
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/jquery-3.2.1.min.js"></script>

    <script src="js/utilidades.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>  
    <script src="js/custom.js"></script>
    
  </body>
</html>