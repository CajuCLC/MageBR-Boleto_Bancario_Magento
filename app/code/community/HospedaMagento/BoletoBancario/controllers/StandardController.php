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
 * @category   Mage
 * @package    HospedaMagento_BoletoBancario
 * @copyright  Copyright (c) 2004-2007 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * BoletoBancario Standard Checkout Controller
 *
 */
 
class HospedaMagento_BoletoBancario_StandardController extends Mage_Core_Controller_Front_Action
{
	public $data=array();
    protected function _expireAjax()
    {
        if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');
            exit;
        }
    }

     /**
     * Get singleton with BoletoBancario strandard order transaction information
     *
     * @return HospedaMagento_BoletoBancario_Model_Standard
     */
    public function getStandard()
    {
        return Mage::getSingleton('BoletoBancario/standard');
    }

     /**
     * When a customer chooses BoletoBancario on Checkout/Payment page
     *
     */
	public function redirectAction()
    {
		//$this->getResponse()->setBody($this->getLayout()->createBlock('BoletoBancario/standard_redirect')->toHtml());

		$session = Mage::getSingleton('checkout/session');

        /** set the quote as inactive after back from paypal    */
        $session->getQuote()->setIsActive(false)->save();

        $this->getStandard()->getOrder()->sendNewOrderEmail();
			
        Mage::dispatchEvent('checkout_onepage_controller_success_action');

        $this->getResponse()->setBody($this->getLayout()->createBlock('BoletoBancario/standard_redirect')->toHtml());

		$session->unsQuoteId();
        //$session->clear();
	}

    /**
     * Try to load valid order by order_id and register it
     *
     * @param int $orderId
     * @return bool
     */
    protected function _loadValidOrder($orderId = null)
    {
        if (null === $orderId) {
            $orderId = (int) $this->getRequest()->getParam('order_id');
        }
        if (!$orderId) {
            $this->_forward('noRoute');
            return false;
        }

        $order = Mage::getModel('sales/order')->load($orderId);

        if ($this->_canViewOrder($order)) {
            Mage::register('current_order', $order);
			return true;
        }
        else {
            $this->_redirect('*/*/history');
        }

        return false;
    }
	
	 /**
     * Check order view availability
     *
     * @param   Mage_Sales_Model_Order $order
     * @return  bool
     */
    protected function _canViewOrder($order)
    {
        /*$customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $availableStates = Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates();
        if ($order->getId() && $order->getCustomerId() && ($order->getCustomerId() == $customerId)
            && in_array($order->getState(), $availableStates, $strict = true)
            ) {
            return true;
        }
        return false;*/

		return(true);
    }
	
	public function gerarAction() {
		$base_url = Mage::getBaseUrl() . "lib/boleto_php/";
		require_once $this->getStandard()->getTemplateBoletoUrl();
		exit();
	}

	public function viewAction() {
        $this->getResponse()->setBody($this->getLayout()->createBlock('BoletoBancario/standard_view')->toHtml());
	}
	
	public function sendmailAction() {
        $this->getResponse()->setBody($this->getLayout()->createBlock('BoletoBancario/standard_sendMail')->toHtml());
	}

    /*
    * When a customer cancel payment from BoletoBancario.
    */
    public function cancelAction()
    {
        //need to save quote as active again if the user click on cacanl payment from BoletoBancario
        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(true)->save();
        //and then redirect to checkout one page
        $this->_redirect('checkout/cart');
     }


    /*
    * when BoletoBancario returns
    * The order information at this point is in POST
    * variables.  However, you don't want to "process" the order until you
    * get validation from the IPN.
    */
	public function successAction()
    {
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getPaypalStandardQuoteId(true));
        /**
         * set the quote as inactive after back from paypal
         */
        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();

        //Mage::getSingleton('checkout/session')->unsQuoteId();

        $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }
	

    /*
    * when BoletoBancario returns via ipn
    * cannot have any output here
    * validate IPN data
    * if data is valid need to update the database that the user has
    */
    public function callbackAction()
    {
        if (!$this->getRequest()->isPost()) {
            return;
        }

        if($this->getStandard()->getDebug()){
            $debug = Mage::getModel('BoletoBancario/api_debug')
                ->setApiEndpoint($this->getStandard()->getBoletoBancarioUrl())
                ->setRequestBody(print_r($this->getRequest()->getPost(),1))
                ->save();
        }

        $this->getStandard()->setIpnFormData($this->getRequest()->getPost());
        //$this->getStandard()->ipnPostSubmit();
		$this->getStandard()->updateOrder();
    }
}
