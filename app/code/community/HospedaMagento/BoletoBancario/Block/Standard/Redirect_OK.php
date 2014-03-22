<?php

class HospedaMagento_BoletoBancario_Block_Standard_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
		$standard = Mage::getModel('BoletoBancario/standard');

		$script =  '<script language="JavaScript">';
		$script .= '	var retorno;';
		$script .= '	var mpg_popup;';
		$script .= '	window.name="boleto";';
		$script .= '	function fabrewin() {';
		$script .= '		if(navigator.appName.indexOf("Netscape") != -1) {';
		$script .= '			mpg_popup = window.open("", "mpg_popup","toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=1,resizable=0,screenX=0,screenY=0,left=0,top=0,width=765,height=440");';
		$script .= '		else';
		$script .= '			mpg_popup = window.open("", "mpg_popup","toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=1,resizable=1,screenX=0,screenY=0,left=0,top=0,width=765,height=440");';
		$script .= '		window.location="aguarde.html";';
		$script .= '     return true;';
		$script .= '	}';
		$script .= '</script>';              

		$form  = '<form action="' . $standard->getBoletoBancarioUrl() . '" ';
		$form .= 'id  ="boleto_standard_checkout" ';
		$form .= 'name="boleto_standard_checkout" ';
		$form .= 'method="post" ';
		$form .= 'target="mpg_popup" ';
		$form .= 'onsubmit="javascript:fabrewin()" ';
		$form .= '>';

        foreach ($standard->getStandardViewFormFields() as $field=>$value) {
            $form .= '<input type="hidden" name="' . $field . '" value="' . $value . '" /> ';
        }
		
		$form .= '</form>';

        $html  = '<html>';
		$html .= '<head>';
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
		$html .= $script;
		$html .= '<body>';
        $html .= $this->__('Você será redirecionado para o Dinheiro Mail em alguns instantes.');
        $html .= $form;
        $html .= '<script type="text/javascript">';
		$html .= '	document.getElementById("boleto_standard_checkout").submit();';
		$html .= '	window.setTimeout("window.location.href = \'' . Mage::getUrl('BoletoBancario/standard/success') . '\'", 1000)';
		$html .= '</script>';
        $html .= '</body></html>';

        return $html;
    }
}
