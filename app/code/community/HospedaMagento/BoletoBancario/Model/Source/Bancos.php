<?php
/**
 * Magento Boleto Bancario
 *
 * @category   Mage
 * @package    HospedaMagento_BoletoBancario
 * @copyright  Author Eric Cavalcanti (hospedamagento@gmail.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class HospedaMagento_BoletoBancario_Model_Source_Bancos
 {
    public function toOptionArray()
    {
        return array(
            array('value' => 'hsbc', 'label' => 'HSBC'),
            array('value' => 'cef', 'label' => 'Caixa Econômica Federal'),
			array('value' => 'cef_sigcb', 'label' => 'Caixa Econômica Federal - SIGCB'),
            array('value' => 'caixa', 'label' => 'Caixa Econômica Federal - Alternativo'),
            array('value' => 'cef_sinco', 'label' => 'Caixa Econômica Federal - SINCO'),
            array('value' => 'bb', 'label' => 'Banco do Brasil'),
            array('value' => 'bradesco', 'label' => 'Bradesco'),
            array('value' => 'itau', 'label' => 'Itaú'),
			array('value' => 'santander_banespa', 'label' => 'Santander'),
        );
    }
 }
