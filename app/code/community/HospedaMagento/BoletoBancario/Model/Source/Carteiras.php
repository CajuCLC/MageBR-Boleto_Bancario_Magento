<?php
/**
 * Magento Boleto Bancario
 *
 * @category   Mage
 * @package    HospedaMagento_BoletoBancario
 * @copyright  Author Eric Cavalcanti (hospedamagento@gmail.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 * PagamentoDigital Payment Action Dropdown source
 *
 */
class HospedaMagento_BoletoBancario_Model_Source_Carteiras
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'SR', 'label' => 'Sem Registro'),
            array('value' => 'CR', 'label' => 'Com Registro'),
            array('value' => 'CNR', 'label' => 'HSBC'),
        );
    }
}
