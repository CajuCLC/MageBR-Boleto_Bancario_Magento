<?php
class boleto
{
 
	function banco_caixa(&$V0842f867){
 $V4ab10179 = "104";
$V92f52e6e = "9";
$V077effb5 = "0";
$V540e4d39 = $this->F540e4d39($V0842f867["data_vencimento"]);
$V01773a8a = $this->F6266027b($V0842f867["valor"],10,"0","v");
$V7c3c1e38 = $V0842f867["carteira"];
$Vef0ad7ba = $this->F6266027b($V0842f867["conta"],8,"0");
$V59a3ce9b = $this->F6266027b($V0842f867["cn_pj"],3,"0");
$V9f808afd = $this->F6266027b($V0842f867["agencia"],4,"0");
if ($V7c3c1e38 == "8"){
 $V0842f867["carteira"] = "SR";
$V5b3b7abe = $this->F6266027b($V0842f867["nosso_numero"],14,"0");
$V7dbac58a = $this->F6266027b($V0842f867["conta"],5,"0");
$V574f61ed = $V7dbac58a . $V9f808afd . $V7c3c1e38 . "7" . $V5b3b7abe;
$V5b3b7abe = "8" . $V5b3b7abe ;
$V1c90f9c3 = $this->F11efdac1($V5b3b7abe,9,0);
$V5b3b7abe = $V5b3b7abe . "-" . $V1c90f9c3;
$Vef0ad7ba = "000" . $V7dbac58a ;
}else if ($V7c3c1e38 == "80" || $V7c3c1e38 == "81" || $V7c3c1e38 == "82" || $V7c3c1e38 == "00"){
 if($V7c3c1e38 == "00"){
 $V0842f867["carteira"] = "CS";
}else{
 $V0842f867["carteira"] = "SR";
}
$V5b3b7abe = $V7c3c1e38 . $this->F6266027b($V0842f867["nosso_numero"],8,"0");
$V574f61ed = $V5b3b7abe . $V9f808afd . $V59a3ce9b . $Vef0ad7ba;
$V1c90f9c3 = $this->F11efdac1($V5b3b7abe,9,0);
$V5b3b7abe = $V5b3b7abe . "-" . $V1c90f9c3;
}else if ($V7c3c1e38 == "9"){
 $V0842f867["carteira"] = "CR";
$V5b3b7abe = $this->F6266027b($V0842f867["nosso_numero"],9,"0");
$V5b3b7abe = "9" . $V5b3b7abe ;
$V574f61ed = $V5b3b7abe . $V9f808afd . $V59a3ce9b . $Vef0ad7ba;
$V1c90f9c3 = $this->F11efdac1($V5b3b7abe,9,0);
$V5b3b7abe = $V5b3b7abe . "-" . $V1c90f9c3;
}else if ($V7c3c1e38 == "99" || $V7c3c1e38 == "90" || $V7c3c1e38 == "01" || $V7c3c1e38 == "1"){
 $Vef0ad7ba = $this->F6266027b($V0842f867["conta"],6,"0");
$V5b3b7abe = $this->F6266027b($V0842f867["nosso_numero"],16,"0");
if( $V7c3c1e38 == "90" || $V7c3c1e38 == "01" || $V7c3c1e38 == "1"){
 $V5b3b7abe = "90" . $V5b3b7abe;
$V0842f867["carteira"] = $V7c3c1e38;
}else{
 $V5b3b7abe = "99" . $V5b3b7abe;
$V0842f867["carteira"] = "01";
}	
 $V574f61ed = "1". $Vef0ad7ba . $V5b3b7abe;
$V1c90f9c3 = $this->F11efdac1($V5b3b7abe,9,0);
$V5b3b7abe = $V5b3b7abe . "-" . $V1c90f9c3;
}
$Vc21a9e1d = "$V4ab10179$V92f52e6e$V540e4d39$V01773a8a$V574f61ed";
$V28dfab58 = $this->F80457cf3($Vc21a9e1d);
$Vc21a9e1d = "$V4ab10179$V92f52e6e$V28dfab58$V540e4d39$V01773a8a$V574f61ed";
if($V7c3c1e38 == "99" || $V7c3c1e38 == "90" || $V7c3c1e38 == "01" || $V7c3c1e38 == "1"){
 $Vaf2c4191 = $V9f808afd ."/". $Vef0ad7ba ;
}else{
 $Vaf2c4191 = $V9f808afd .".". $V59a3ce9b .".". $Vef0ad7ba ."-". $V0842f867["dac_conta"];	
 }	
 $V0842f867["codigo_barras"] = "$Vc21a9e1d";
$V0842f867["linha_digitavel"] = $this->F5aef63b6($Vc21a9e1d);	
 $V0842f867["agencia_codigo"] = $Vaf2c4191 ;
$V0842f867["nosso_numero"] = $V5b3b7abe;
	// echo "$Vc21a9e1d";
}
 
 function F80457cf3($V0842f867){
 $V0842f867 = $this->F11efdac1($V0842f867);
if($V0842f867==0 || $V0842f867 >9) $V0842f867 = 1;
return $V0842f867;
}

 function F540e4d39($V0842f867){
 $V0842f867 = str_replace("/","-",$V0842f867);
$V465b1f70 = explode("-",$V0842f867);
return $this->F1b261b5c($V465b1f70[2], $V465b1f70[1], $V465b1f70[0]);
}

 function F1b261b5c($Vbde9dee6, $Vd2db8a61, $V465b1f70)
 {
 return(abs(($this->F5a66daf8("1997","10","07")) - ($this->F5a66daf8($Vbde9dee6, $Vd2db8a61, $V465b1f70))));
}
function F5a66daf8($V84cdc76c,$V7436f942,$V628b7db0)
 {
 $V151aa009 = substr($V84cdc76c, 0, 2);
$V84cdc76c = substr($V84cdc76c, 2, 2);
if ($V7436f942 > 2) {
 $V7436f942 -= 3;
} else {
 $V7436f942 += 9;
if ($V84cdc76c) {
 $V84cdc76c--;
} else {
 $V84cdc76c = 99;
$V151aa009 --;
}
}
return ( floor(( 146097 * $V151aa009) / 4 ) +
 floor(( 1461 * $V84cdc76c) / 4 ) +
 floor(( 153 * $V7436f942 + 2) / 5 ) +
 $V628b7db0 + 1721119);
}
function F11efdac1($V0fc3cfbc, $V593616de=9, $V4b43b0ae=0)
 {
 $V15a00ab3 = 0;
$V44f7e37e = 2;
 
 for ($V865c0c0b = strlen($V0fc3cfbc); $V865c0c0b > 0; $V865c0c0b--) {
 
 $V5e8b750e[$V865c0c0b] = substr($V0fc3cfbc,$V865c0c0b-1,1);
 
 $Vb040904b[$V865c0c0b] = $V5e8b750e[$V865c0c0b] * $V44f7e37e;
 
 $V15a00ab3 += $Vb040904b[$V865c0c0b];
if ($V44f7e37e == $V593616de) {
 
 $V44f7e37e = 1;
}
$V44f7e37e++;
}
 
 if ($V4b43b0ae == 0) {
 $V15a00ab3 *= 10;
$V05fbaf7e = $V15a00ab3 % 11;
if ($V05fbaf7e == 10) {
 $V05fbaf7e = 0;
}
return $V05fbaf7e;
} elseif ($V4b43b0ae == 1){
 $V9c6350b0 = $V15a00ab3 % 11;
return $V9c6350b0;
}
}
function Fd1ea9d43($V0fc3cfbc)
 { 
 $V4ec61c61 = 0;
$V44f7e37e = 2;
 
 for ($V865c0c0b = strlen($V0fc3cfbc); $V865c0c0b > 0; $V865c0c0b--) {
 
 $V5e8b750e[$V865c0c0b] = substr($V0fc3cfbc,$V865c0c0b-1,1);
 
 $Vee487e79[$V865c0c0b] = $V5e8b750e[$V865c0c0b] * $V44f7e37e;
 
 $V4ec61c61 .= $Vee487e79[$V865c0c0b];
if ($V44f7e37e == 2) {
 $V44f7e37e = 1;
} else {
 $V44f7e37e = 2; 
 }
}
$V15a00ab3 = 0;
 
 for ($V865c0c0b = strlen($V4ec61c61); $V865c0c0b > 0; $V865c0c0b--) {
 $V5e8b750e[$V865c0c0b] = substr($V4ec61c61,$V865c0c0b-1,1);
$V15a00ab3 += $V5e8b750e[$V865c0c0b]; 
 }
$V9c6350b0 = $V15a00ab3 % 10;
$V05fbaf7e = 10 - $V9c6350b0;
if ($V9c6350b0 == 0) {
 $V05fbaf7e = 0;
}
return $V05fbaf7e;
}
function F5aef63b6($V41ef8940)
 {
 
  
 $Vec6ef230 = substr($V41ef8940, 0, 4);
$V1d665b9b = substr($V41ef8940, 19, 5);
$V7bc3ca68 = $this->Fd1ea9d43("$Vec6ef230$V1d665b9b");
$V13207e3d = "$Vec6ef230$V1d665b9b$V7bc3ca68";
$Ved92eff8 = substr($V13207e3d, 0, 5);
$Vc6c27fc9 = substr($V13207e3d, 5);
$V8a690a8f = "$Ved92eff8.$Vc6c27fc9";
  
 $Vec6ef230 = substr($V41ef8940, 24, 10);
$V1d665b9b = $this->Fd1ea9d43($Vec6ef230);
$V7bc3ca68 = "$Vec6ef230$V1d665b9b";
$V13207e3d = substr($V7bc3ca68, 0, 5);
$Ved92eff8 = substr($V7bc3ca68, 5);
$V4499f7f9 = "$V13207e3d.$Ved92eff8";
  
 $Vec6ef230 = substr($V41ef8940, 34, 10);
$V1d665b9b = $this->Fd1ea9d43($Vec6ef230);
$V7bc3ca68 = "$Vec6ef230$V1d665b9b";
$V13207e3d = substr($V7bc3ca68, 0, 5);
$Ved92eff8 = substr($V7bc3ca68, 5);
$V9e911857 = "$V13207e3d.$Ved92eff8";
 
 $V0db9137c = substr($V41ef8940, 4, 1);
   
 $Va7ad67b2 = substr($V41ef8940, 5, 14);
return "$V8a690a8f $V4499f7f9 $V9e911857 $V0db9137c $Va7ad67b2"; 
 }
function F294e91c9($V4d5128a0)
 {
 $Ve2b64fe0 = substr($V4d5128a0, 0, 3);
$V284e2ffa = $this->F11efdac1($Ve2b64fe0);

 return $Ve2b64fe0 . "-" . $V284e2ffa;
}

 function F6266027b($V0842f867, $Vce2db5d6, $V0152807c, $V401281b0 = "e"){
 if($V401281b0=="v"){
 $V0842f867 = str_replace(".","",$V0842f867); 
 $V0842f867 = str_replace(",",".",$V0842f867); 
 $V0842f867 = number_format($V0842f867,2,"","");
$V0842f867 = str_replace(".","",$V0842f867); 
 $V401281b0 = "e";
}
while(strlen($V0842f867)<$Vce2db5d6){
 if($V401281b0=="e"){
 $V0842f867 = $V0152807c . $V0842f867;
}else{
 $V0842f867 = $V0842f867 . $V0152807c;
}
}
if(strlen($V0842f867)>$Vce2db5d6){
 if($V401281b0 == "e"){
 $V0842f867 = $this->F8277e091($V0842f867,$Vce2db5d6);
}else{
 $V0842f867 = $this->Fe1671797($V0842f867,$Vce2db5d6);	
 }
}
return $V0842f867;	
 }
function Fe1671797($V0842f867,$V005480c8){
 return substr($V0842f867,0,$V005480c8);
}
function F8277e091($V0842f867,$V005480c8){
 return substr($V0842f867,strlen($V0842f867)-$V005480c8,$V005480c8);
}

 
}
 
function fbarcode($V01773a8a, $dir){
$V77e77c6a = 1 ;
$V5f44b105 = 3 ;
$V2c9890f4 = 50 ;
$Ve5200a9e[0] = "00110" ;
$Ve5200a9e[1] = "10001" ;
$Ve5200a9e[2] = "01001" ;
$Ve5200a9e[3] = "11000" ;
$Ve5200a9e[4] = "00101" ;
$Ve5200a9e[5] = "10100" ;
$Ve5200a9e[6] = "01100" ;
$Ve5200a9e[7] = "00011" ;
$Ve5200a9e[8] = "10010" ;
$Ve5200a9e[9] = "01010" ;
for($Vbd19836d=9;$Vbd19836d>=0;$Vbd19836d--){ 
 for($V3667f6a0=9;$V3667f6a0>=0;$V3667f6a0--){ 
 $V8fa14cdd = ($Vbd19836d * 10) + $V3667f6a0 ;
$V62059a74 = "" ;
for($V865c0c0b=1;$V865c0c0b<6;$V865c0c0b++){ 
 $V62059a74 .= substr($Ve5200a9e[$Vbd19836d],($V865c0c0b-1),1) . substr($Ve5200a9e[$V3667f6a0],($V865c0c0b-1),1);
}
$Ve5200a9e[$V8fa14cdd] = $V62059a74;
}
}
 
 
?><img src=<?php echo $dir; ?>imagens/p.gif width=<?=$V77e77c6a?> height=<?=$V2c9890f4?> border=0><img 
src=<?php echo $dir; ?>imagens/b.gif width=<?=$V77e77c6a?> height=<?=$V2c9890f4?> border=0><img 
src=<?php echo $dir; ?>imagens/p.gif width=<?=$V77e77c6a?> height=<?=$V2c9890f4?> border=0><img 
src=<?php echo $dir; ?>imagens/b.gif width=<?=$V77e77c6a?> height=<?=$V2c9890f4?> border=0><img 
<?
$V62059a74 = $V01773a8a ;
if((strlen($V62059a74)%2) <> 0){
	$V62059a74 = "0" . $V62059a74;
}
 
while (strlen($V62059a74) > 0) {
 $V865c0c0b = round(Ff2317ae6($V62059a74,2));
$V62059a74 = F0835e508($V62059a74,strlen($V62059a74)-2);
$V8fa14cdd = $Ve5200a9e[$V865c0c0b];
for($V865c0c0b=1;$V865c0c0b<11;$V865c0c0b+=2){
 if (substr($V8fa14cdd,($V865c0c0b-1),1) == "0") {
 $Vbd19836d = $V77e77c6a ;
}else{
 $Vbd19836d = $V5f44b105 ;
}
?>
 src=<?php echo $dir; ?>imagens/p.gif width=<?=$Vbd19836d?> height=<?=$V2c9890f4?> border=0><img 
<?
 if (substr($V8fa14cdd,$V865c0c0b,1) == "0") {
 $V3667f6a0 = $V77e77c6a ;
}else{
 $V3667f6a0 = $V5f44b105 ;
}
?>
 src=<?php echo $dir; ?>imagens/b.gif width=<?=$V3667f6a0?> height=<?=$V2c9890f4?> border=0><img 
<?
 }
}
 
?>
src=<?php echo $dir; ?>imagens/p.gif width=<?=$V5f44b105?> height=<?=$V2c9890f4?> border=0><img 
src=<?php echo $dir; ?>imagens/b.gif width=<?=$V77e77c6a?> height=<?=$V2c9890f4?> border=0><img 
src=<?php echo $dir; ?>imagens/p.gif width=<?=1?> height=<?=$V2c9890f4?> border=0> <?
} 
function Ff2317ae6($V0842f867,$V005480c8){
	return substr($V0842f867,0,$V005480c8);
}
function F0835e508($V0842f867,$V005480c8){
	return substr($V0842f867,strlen($V0842f867)-$V005480c8,$V005480c8);
}
?>