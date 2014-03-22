<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto HSBC: Bruno Leonardo M. F. Gonçalves          |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

//converte string UTF8 para ISO-8859-1
foreach ($_POST as $key => $value) {
    $_POST[$key] = utf8_decode($value);
}

//  pegando os dados via post
$base_url = $_POST['base_url'];
if (strrpos($base_url, '/') != strlen($base_url) - 1) {
	$base_url .= '/'; 
}

$dadosboleto["logo_url"] = $_POST["logo_url"]; 
$dadosboleto["store_url"] = $_POST["store_url"]; 



// DADOS DO BOLETO PARA O SEU CLIENTE


$dias_de_prazo_para_pagamento = $_POST["prazo_pagamento"];
$taxa_boleto = $_POST["taxa_boleto"];
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $_POST["total_pedido"]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');



$dadosboleto["numero_documento"] = $_POST["ref_transacao"];	// Número do documento - REGRA: Máximo de 13 digitos
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_POST["cliente_nome"];
$dadosboleto["endereco1"] = $_POST["cliente_end"];
$dadosboleto["endereco2"] = $_POST["cliente_cep"]." ".$_POST["cliente_cidade"]." ".$_POST["cliente_uf"];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $_POST["demonstrativo1"];
$dadosboleto["demonstrativo2"] = $_POST["demonstrativo2"];
$dadosboleto["demonstrativo3"] = $_POST["demonstrativo3"];

if ($dadosboleto["demonstrativo2"] == '') {
	$dadosboleto["demonstrativo2"] == "Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
}
if ($dadosboleto["demonstrativo3"] == '') {
	$dadosboleto["demonstrativo3"] == "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";
}

$dadosboleto["instrucoes1"] = $_POST["instrucoes1"];
$dadosboleto["instrucoes2"] = $_POST["instrucoes2"];
$dadosboleto["instrucoes3"] = $_POST["instrucoes3"];
$dadosboleto["instrucoes4"] = $_POST["instrucoes4"];

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] =  $_POST["especie"];
$dadosboleto["especie_doc"] = $_POST["especie"];


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - HSBC
$dadosboleto["codigo_cedente"] = $_POST["conta_cedente"]; // Código do Cedente (Somente 7 digitos)
$dadosboleto["carteira"] = $_POST["carteira"];//"CNR";  // Código da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] = $_POST["identificacao"];// "BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = $_POST["cpf_cnpj"];
$dadosboleto["endereco"] = $_POST["endereco"];
$dadosboleto["cidade_uf"] = $_POST["cidade_uf"];
$dadosboleto["cedente"] = $_POST["cedente"];

// NÃO ALTERAR!
include("include/funcoes_hsbc.php"); 
include("include/layout_hsbc.php");
?>
