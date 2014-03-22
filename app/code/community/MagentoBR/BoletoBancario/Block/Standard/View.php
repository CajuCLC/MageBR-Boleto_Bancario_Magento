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
 * Boleto Bancário view block
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class MagentoBR_BoletoBancario_Block_Standard_View extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        //$this->setTemplate('BoletoBancario/view.phtml');
    }

    protected function _prepareLayout()
    {
        /*if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->__('Order # %s', $this->getOrder()->getRealOrderId()));
        }
        $this->setChild(
            'payment_info',
            $this->helper('payment')->getInfoBlock($this->getOrder()->getPayment())
        );*/
		
		parent::_construct();
    }
    
	protected function _toHtml()
    {
		$standard = Mage::getModel('BoletoBancario/standard');
		$order_id = $this->getRequest()->getParam('order_id');

        $form = new Varien_Data_Form();
        $form->setAction($standard->getBoletoBancarioViewUrl())
            ->setId('BoletoBancario_standard_view')
            ->setName('BoletoBancario_standard_view')
            ->setMethod('POST')
            ->setUseContainer(true);
        
		foreach ($standard->getStandardViewFormFields($this->getOrder($order_id)) as $field=>$value) {
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
		
		//echo $this->getOrder()->getBillingAddress();
		
		$html.= '<script type="text/javascript">setTimeout(function(){document.getElementById("BoletoBancario_standard_view").submit()}, 2000);</script>';
        $html.= '</body></html>';

        return $html;
    }
	
    public function getPaymentInfoHtml()
    {
        return $this->getChildHtml('payment_info');
    }

    /**
     * Retrieve current order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder($orderId = null)
    {
		return (Mage::getModel('BoletoBancario/standard')->getOrder($orderId));
    }

    public function getBackUrl()
    {
        return Mage::getUrl('*/*/history');
    }

    public function getInvoiceUrl($order)
    {
        return Mage::getUrl('*/*/invoice', array('order_id' => $order->getId()));
    }

    public function getShipmentUrl($order)
    {
        return Mage::getUrl('*/*/shipment', array('order_id' => $order->getId()));
    }

    public function getCreditmemoUrl($order)
    {
        return Mage::getUrl('*/*/creditmemo', array('order_id' => $order->getId()));
    }

}
