<?php

/**
 *
 * Boleto Bancario  Standard Checkout Module
 *
*/

class MagentoBR_BoletoBancario_Model_Standard extends Mage_Payment_Model_Method_Abstract
{
    //changing the payment to different from cc payment type and BoletoBancario payment type
    const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
    const PAYMENT_TYPE_SALE = 'SALE';

  
	protected $_code  = 'BoletoBancario_standard';
	protected $_canUseInternal = true;
	protected $_canCapture = true;
	
    protected $_successBlockType = 'BoletoBancario/standard_success';
	protected $_sucessoBlockType = 'BoletoBancario/standard_sucesso';
    protected $_infoBlockType = 'BoletoBancario/standard_info';
    protected $_formBlockType = 'BoletoBancario/standard_form';
	protected $_allowCurrencyCode = array('AUD', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'JPY', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD','USD');

     /**
     * Get BoletoBancario session namespace
     *
     * @return MagentoBR_BoletoBancario_Model_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('BoletoBancario/session');
    }

    /**
     * Get checkout session namespace
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current quote
     *
     * @return Mage_Sales_Model_Quote
     */    
    public function getQuote($quote_id = null) {
		if (!empty($quote_id)) {
			return Mage::getModel('sales/quote')->load($quote_id);
		}
		else {
			return $this->getCheckout()->getQuote();
		}
    }
    /**
     * Using internal pages for input payment data
     *
     * @return bool
     */
    public function canUseInternal()
    {
        return true;
    }

    /**
     * Using for multiple shipping address
     *
     * @return bool
     */
    public function canUseForMultishipping()
    {
        return true;
    }

    public function createFormBlock($name)
    {
        $block = $this->getLayout()->createBlock('BoletoBancario/standard_form', $name)
            ->setMethod('BoletoBancario_standard')
            ->setPayment($this->getPayment())
            ->setTemplate('BoletoBancario/standard/form.phtml');

        return $block;
    }
	
	///Add New
	public function getTransactionId()
    {
        return $this->getSessionData('transaction_id');
    }

    public function setTransactionId($data)
    {
        return $this->setSessionData('transaction_id', $data);
    }
	///Add New
    /*validate the currency code is avaialable to use for BoletoBancario or not*/
    public function validate()
    {
        parent::validate();
		$tWeight=0;		
		 $items = $this->getQuote()->getAllItems();
            if ($items) {
                $i = 1;
                foreach($items as $item){
					$tWeight=$tWeight+$item->getWeight();
                    $i++;
                }
           }
		if($tWeight >= 30001)
		{
		  Mage::throwException(Mage::helper('BoletoBancario')->__('   Teste de limite de 30 kg   '));
		}
		
        return $this;
    }

    public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment)
    {
       return $this;
    }

    public function onInvoiceCreate(Mage_Sales_Model_Invoice_Payment $payment)
    {
		return $this;
    }

    public function canCapture()
    {
        return true;
    }

    public function getOrderPlaceRedirectUrl()
    {
		  return Mage::getUrl('BoletoBancario/standard/redirect');
    }
	
	// GERA O VIEW PARA SEGUNDA VIA
	public function getStandardViewFormFields($order) {
	
        $a = $order->getBillingAddress();

		$sArr = array(
			'base_url'			=> $this->getLibBoletoUrl(),
			'logo_url'			=> $this->getLogoPrint(),
			'store_url'			=> Mage::getBaseUrl(),
			'ref_transacao'     => $order->getRealOrderId(),
            'cliente_nome'      => $a->getFirstname().' '.$a->getLastname(),
            'cliente_cep'       => $a->getPostcode(),
            'cliente_end'       => $a->getStreet(1),
            'cliente_num'       => "?",
            'cliente_compl'     =>  $a->getStreet(2),
            'cliente_bairro'    => "?",
            'cliente_cidade'    => $a->getCity(),
            'cliente_uf'        => $a->getRegion(),
            'cliente_pais'      => "BRA",
			'cliente_cpf'       => "?",
			'total_pedido'      => $order->getGrandTotal(),
			'prazo_pagamento'	=> $this->getConfigData('prazo_pagamento'),		
			'taxa_boleto'		=> $this->getConfigData('taxa_boleto'),		
			'inicio_nosso_numero'	=> $this->getConfigData('inicio_nosso_numero'),		
			'digitos_nosso_numero' => $this->getConfigData('digitos_nosso_numero'),
			'demonstrativo1'	=> $this->getConfigData('demonstrativo1'),		
			'demonstrativo2'	=> $this->getConfigData('demonstrativo2'),		
			'demonstrativo3'	=> $this->getConfigData('demonstrativo3'),		
			'instrucoes1'		=> $this->getConfigData('instrucoes1'),		
			'instrucoes2'		=> $this->getConfigData('instrucoes2'),		
			'instrucoes3'		=> $this->getConfigData('instrucoes3'),		
			'instrucoes4'		=> $this->getConfigData('instrucoes4'),		
			'banco'				=> $this->getConfigData('banco'),		
			'agencia'			=> $this->getConfigData('agencia'),		
			'agencia_dv'		=> $this->getConfigData('agencia_dv'),		
			'conta'				=> $this->getConfigData('conta'),		
			'conta_dv'			=> $this->getConfigData('conta_dv'),		
			'conta_cedente'		=> $this->getConfigData('conta_cedente'),		
			'conta_cedente_dv'	=> $this->getConfigData('conta_cedente_dv'),		
			'carteira'			=> $this->getConfigData('carteira'),		
			'especie'			=> $this->getConfigData('especie'),		
			'variacao_carteira'	=> $this->getConfigData('variacao_carteira'),		
			'contrato'			=> $this->getConfigData('contrato'),		
			'convenio'			=> $this->getConfigData('convenio'),		
			'cedente'			=> $this->getConfigData('cedente'),		
			'identificacao'		=> $this->getConfigData('identificacao'),		
			'cpf_cnpj'			=> $this->getConfigData('cpf_cnpj'),		
			'endereco'			=> $this->getConfigData('endereco'),		
			'cidade_uf'			=> $this->getConfigData('cidade_uf'),		
			'secancelado' 		=> $this->getConfigData('secancelado'),		
        );
		
		$sReq = '';
        $rArr = array();
        /*replacing & char with and. otherwise it will break the post*/
        foreach ($sArr as $k=>$v) {
            $value =  str_replace("&","and",$v);
            $rArr[$k] =  $value;
            $sReq .= '&'.$k.'='.$value;
        }

        if ($this->getDebug() && $sReq) {
            $sReq = substr($sReq, 1);
            $debug = Mage::getModel('BoletoBancario/api_debug')
                    ->setApiEndpoint($this->getBoletoBancarioViewUrl())
                    ->setRequestBody($sReq)
                    ->save();
        }
        return $rArr;
	}
	
    /**
     * Retrieve url of skins file
     *
     * @param   string $file path to file in skin
     * @param   array $params
     * @return  string
     */
    public function getSkinUrl($file=null, array $params=array())
    {
        return Mage::getDesign()->getSkinUrl($file, $params);
    }

    public function getLogoPrint()
    {
		$pathLogo = $this->getConfigData('path_logo');
		if ($pathLogo == '') {
			$pathLogo = 'images/logo_print.gif';
		}
		return $this->getSkinUrl($pathLogo);
    }

	// GERA O BOLETO NO CHECKOUT
	public function getStandardCheckoutFormFields($order) {
	$order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
        $a = $order->getBillingAddress();

		$sArr = array(
			'base_url'			=> $this->getLibBoletoUrl(),
			'logo_url'			=> $this->getLogoPrint(),
			'store_url'			=> Mage::getBaseUrl(),
			'ref_transacao'     => $order->getRealOrderId(),
            'cliente_nome'      => $a->getFirstname().' '.$a->getLastname(),
            'cliente_cep'       => $a->getPostcode(),
            'cliente_end'       => $a->getStreet(1),
            'cliente_num'       => "?",
            'cliente_compl'     =>  $a->getStreet(2),
            'cliente_bairro'    => "?",
            'cliente_cidade'    => $a->getCity(),
            'cliente_uf'        => $a->getRegion(),
            'cliente_pais'      => "BRA",
			'cliente_cpf'       => "?",
			'total_pedido'      => $order->getGrandTotal(),
			'prazo_pagamento'	=> $this->getConfigData('prazo_pagamento'),		
			'taxa_boleto'		=> $this->getConfigData('taxa_boleto'),		
			'inicio_nosso_numero'	=> $this->getConfigData('inicio_nosso_numero'),		
			'digitos_nosso_numero' => $this->getConfigData('digitos_nosso_numero'),
			'demonstrativo1'	=> $this->getConfigData('demonstrativo1'),		
			'demonstrativo2'	=> $this->getConfigData('demonstrativo2'),		
			'demonstrativo3'	=> $this->getConfigData('demonstrativo3'),		
			'instrucoes1'		=> $this->getConfigData('instrucoes1'),		
			'instrucoes2'		=> $this->getConfigData('instrucoes2'),		
			'instrucoes3'		=> $this->getConfigData('instrucoes3'),		
			'instrucoes4'		=> $this->getConfigData('instrucoes4'),		
			'banco'				=> $this->getConfigData('banco'),		
			'agencia'			=> $this->getConfigData('agencia'),		
			'agencia_dv'		=> $this->getConfigData('agencia_dv'),		
			'conta'				=> $this->getConfigData('conta'),		
			'conta_dv'			=> $this->getConfigData('conta_dv'),		
			'conta_cedente'		=> $this->getConfigData('conta_cedente'),		
			'conta_cedente_dv'	=> $this->getConfigData('conta_cedente_dv'),		
			'carteira'			=> $this->getConfigData('carteira'),		
			'especie'			=> $this->getConfigData('especie'),		
			'variacao_carteira'	=> $this->getConfigData('variacao_carteira'),		
			'contrato'			=> $this->getConfigData('contrato'),		
			'convenio'			=> $this->getConfigData('convenio'),		
			'cedente'			=> $this->getConfigData('cedente'),		
			'identificacao'		=> $this->getConfigData('identificacao'),		
			'cpf_cnpj'			=> $this->getConfigData('cpf_cnpj'),		
			'endereco'			=> $this->getConfigData('endereco'),		
			'cidade_uf'			=> $this->getConfigData('cidade_uf'),		
			'secancelado' 		=> $this->getConfigData('secancelado'),		
        );
		
		$sReq = '';
        $rArr = array();
        /*replacing & char with and. otherwise it will break the post*/
        foreach ($sArr as $k=>$v) {
            $value =  str_replace("&","and",$v);
            $rArr[$k] =  $value;
            $sReq .= '&'.$k.'='.$value;
        }

        if ($this->getDebug() && $sReq) {
            $sReq = substr($sReq, 1);
            $debug = Mage::getModel('BoletoBancario/api_debug')
                    ->setApiEndpoint($this->getBoletoBancarioUrl())
                    ->setRequestBody($sReq)
                    ->save();
        }
        return $rArr;
	}
	
	public function getOrder($order_id = null) {
		if (empty($order_id)) {
			$order = Mage::registry('current_order');
		}
		else {
			$order = Mage::getModel('sales/order')->load($order_id);
		}
		
		if (empty($order)) {
			$order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
			$order = Mage::getModel('sales/order')->load($order_id);
		}

		return($order);
	}

	private function getHost($url) {
		// get host name from URL
		preg_match('@^(?:http(s*)://)?([^/]+)@i', $url, $matches);
		
		return($matches[1] . $matches[2]);
	}

		// public function usado no view de segunda via.
	    public function getBoletoBancarioViewUrl()
    {
		// Esta versao da problemas com SSL.
		// $url = Mage::getUrl("BoletoBancario/standard/gerar",array('_secure'=>true));
        // return $home_url .'BoletoBancario/standard/gerar';
		
		//Esta versao esta ok com SSL
		// $home_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$home_url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
		return $home_url .'BoletoBancario/standard/gerar';
    }
	
	// public function usado no checkout.
    public function getBoletoBancarioUrl()
    {
		// Esta versao da problemas com SSL.
		// $url = Mage::getUrl("BoletoBancario/standard/gerar",array('_secure'=>true));
        // return $home_url .'BoletoBancario/standard/gerar';
		
		//Esta versao esta ok com SSL
		// $home_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$home_url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
		return $home_url .'BoletoBancario/standard/success';
    }
	
	public function getLibBoletoUrl() {
		$urlBase = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
		$urlBase = 'http://' . $this->getHost($urlBase);
		
		$ret = $urlBase . "/lib/boleto_php"; 
		
		return($ret);
	}

	public function getTemplateBoletoUrl() {
		$ret = $GLOBALS['paths'][3] . "/boleto_php/boleto_" . $this->getConfigData('banco') . ".php"; 
		
		return($ret);
	}

	public function getDebug()
	{
		$ret = Mage::getStoreConfig('payment/visanet/debug');
		if (!$ret) {
			$ret = $this->getConfigData('debug');
		}
		return $ret;
	}
	
	public function updateOrder($FromData)
	{
		
	}

    public function ipnPostSubmit()
    {
    }

	public function sendHTMLemail($message, $from='', $to='', $subject) 
	{
		if ($to == '') { //recupera o e-mail do cliente
			$to = $this->getQuote()->getShippingAddress()->getEmail();
		}

		// To send the HTML mail we need to set the Content-type header.
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers  .= "From: $from\r\n";
		//options to send to cc+bcc
		//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
		//$headers .= "Bcc: [email]email@maaking.cXom[/email]";
		
	    return(mail($to,$subject,$message,$headers));    
	}
}
