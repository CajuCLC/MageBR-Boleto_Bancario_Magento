<?php
/**
 * Magento Boleto Bancario
 *
 * @category   Mage
 * @package    MageBR_BoletoBancario
 * @copyright  Author Eric Cavalcanti (MageBR@gmail.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 * PagamentoDigital Payment Action Dropdown source
 *
 */

class MageBR_BoletoBancario_Model_Source_SeCancelado
 {
    public function toOptionArray()
    {
        return array(
            array('value' => 'sim', 'label' => 'Sim'),
            array('value' => 'nao', 'label' => 'Nao'),
        );
    }
 }