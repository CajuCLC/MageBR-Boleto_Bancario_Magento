<?php

class HospedaMagento_BoletoBancario_Block_Standard_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
		$standard = Mage::getModel('BoletoBancario/standard');

		//recupera dados da compra
		/*
		$order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
		$order = Mage::getModel('sales/order')->load($order_id);
		$a = $order->getBillingAddress();

		//envia e-mail com a segunda via do boleto
		$to = $a->getEmail();
		$from = $this->getStandard()->getConfigData('MarchentEmailID');
		$subject = "Boleto Bancário - 2� via";
		$body = '<a href="' . Mage::getUrl("BoletoBancario/standard/view/order_id/$order_id") . '" target="boleto">Clique aqui para exibir a 2� via do boleto</a>';
		
		$this->getStandard()->sendHTMLemail($body, $from, $to, $subject);
		*/

        $form = new Varien_Data_Form();
        $form->setAction($standard->getBoletoBancarioUrl())
            ->setId('BoletoBancario_standard_checkout')
            ->setName('BoletoBancario_standard_checkout')
            ->setMethod('POST')
			->setTarget('boleto')
            ->setUseContainer(true);
        
		foreach ($standard->getStandardCheckoutFormFields() as $field=>$value) {
            $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
        }
		
        $html = '<html><body>';
        $html.= $this->__('Voce sera redirecionado para o boleto em alguns segundos.');				
        $html.= $form->toHtml();
        $html.= '<script type="text/javascript">document.getElementById("BoletoBancario_standard_checkout").submit();</script>';
        $html.= '</body></html>';

        return $html;
    }
}