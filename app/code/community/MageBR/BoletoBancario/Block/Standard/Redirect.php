<?php

class MageBR_BoletoBancario_Block_Standard_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
		$standard = Mage::getModel('BoletoBancario/standard');

		//recupera dados da compra
		$order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
		$order = Mage::getModel('sales/order')->load($order_id);
		$a = $order->getBillingAddress();

		//envia e-mail com a segunda via do boleto
		/*
		$to = $a->getEmail();
		$from = $this->getStandard()->getConfigData('MarchentEmailID');
		$subject = "Boleto Bancário - 2ª via";
		$body = '<a href="' . Mage::getUrl("BoletoBancario/standard/view/order_id/$order_id") . '" target="boleto">Clique aqui para exibir a 2ª via do boleto</a>';
		
		$this->getStandard()->sendHTMLemail($body, $from, $to, $subject);
		*/

        $form = new Varien_Data_Form();
        $form->setAction($standard->getBoletoBancarioUrl())
            ->setId('BoletoBancario_standard_checkout')
            ->setName('BoletoBancario_standard_checkout')
            ->setMethod('POST')
			->setTarget('boleto')
            ->setUseContainer(true);
        
		foreach ($standard->getStandardCheckoutFormFields($order) as $field=>$value) {
            $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
        }
		
		$home_url = $this->getSkinUrl('images/boleto/boleto.png');
		$carregando = $this->getSkinUrl('images/boleto/boletocarregando.gif');
        $html = '<html><body>';
        $html.= $this->__('<p align="center"><strong>Estamos gerando o seu Boleto.</strong></p>
		<p align="center"><strong>Aguarde...</strong></p>
			<p align="center">
			<img src="'. $carregando .'" width="169" height="70" /><br /><br />
			<input type="image" src="'. $home_url .'" value="Gerando o Boleto" width="128" height="128"/>
			</p>');
        $html.= $form->toHtml();
        $html.= '<script type="text/javascript">setTimeout(function(){document.getElementById("BoletoBancario_standard_checkout").submit()}, 2000);</script>';
        $html.= '</body></html>';

        return $html;
    }
}