<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Sales
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Boleto Bancario SendMail block
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
 
class MagentoBR_BoletoBancario_Block_Standard_Sendmail extends Mage_Core_Block_Template
 {
    protected function _construct()
    {
        parent::_construct();
    }

  protected function _toHtml()
    {
    $standard = Mage::getModel('BoletoBancario/standard');
    $order_id = $this->getRequest()->getParam('order_id');
    $order = $standard->getOrder($order_id);

    $subject = Mage::getStoreConfig('system/store/name', $order->getStoreId()) . ' - Segunda via de Boleto';
    $from = Mage::getStoreConfig('trans_email/ident_general/email', $order->getStoreId());
    $to = $order->getCustomerEmail();

    $html = '<html><body>';

        $html .= $this->__('Enviando boleto ao cliente...') . '<br /><br />';        
        $html .= 'Assunto: ' . $subject . '<br />';        
        $html .= 'De: ' . $from . '<br />';        
        $html .= 'Para: ' . $to . '<br />';        
    $html .= '<br />';
    
    $retSend = $this->sendEmail($subject, $from, $to, $order_id, $order);
    
        if ($retSend == 1) {
      $html .= '<b>' . $this->__('Boleto enviado ao cliente com sucesso.') . '</b><br />';        
	  $html .= '<b> <a href="JavaScript:window.close()">Fechar Janela</a> </b>';        
    }
    else {
      $html .= '<b>' . $this->__('Falha ao enviar o boleto.') . ' - ' . $retSend . '</b>';        
	  $html .= '<b> <a href="JavaScript:window.close()">Fechar Janela</a> </b>';        
    }
    
        $html .= '</body></html>';
    
        return $html;
    }
  
    public function getPaymentInfoHtml()
    {
        return $this->getChildHtml('payment_info');
    }
  
  public function sendEmail($subject, $from, $to, $order_id, $order) {
  // $cls  = new Mage_Core_Model_Design_Package();
  // $path = $cls->getSkinBaseUrl();
  $logoboleto = $this->getSkinUrl("images/boleto/logo_boleto.png");
  $a = $order->getBillingAddress();

    // $html  = '<img src="' . $path . 'images/boleto/logo_boleto.png" /> <br />';
	$html  = '<img src="'. $logoboleto .'" /> <br /><br />';
    $html .= 'Caro cliente <strong>' . $a->getFirstname().' '.$a->getLastname() . '</strong>,<br /><br />';
	$html .= 'Estamos enviando este email com a segunda via do boleto de seu pedido <strong># ' . $order->getRealOrderId() . '</strong>. <br />';
    $html .= 'Clique no link abaixo para ver e imprimir a segunda via do boleto. <br /><br />';
    $html .= '<a href="' . Mage::getUrl("BoletoBancario/standard/view/order_id/$order_id") . '" target="boleto"><strong>Segunda via do boleto</strong></a>.';
    $html .= '<br /><br />';
    $html .= 'Atenciosamente, <br /><br />';
    $html .= Mage::getStoreConfig('system/store/name', $order->getStoreId());
    
    $ret = $this->getStandard()->sendHTMLemail($html, $from, $to, $subject);
    
    return($ret);
  }

  public function getStandard()
    {
        return Mage::getSingleton('BoletoBancario/standard');
    }

 }
