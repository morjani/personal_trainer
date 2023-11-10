<?php
session_cache_expire (30);
$cache_expire = session_cache_expire();

session_start();
//error_reporting(0);
//$site= "http://sm-mobile/test/"; ///// iciii l'adress de site
$site=  "https://".$_SERVER['HTTP_HOST']."/Admin/" ; ///// iciii l'adress de site
$site2=  "https://".$_SERVER['HTTP_HOST']."/" ; ///// iciii l'adress de site
$host='verychicckbd.mysql.db';
$user='verychicckbd';
$pass='Dido212133';
$base='verychicckbd'; //i250570


date_default_timezone_set('GMT');



if ( $enconstruction == "oui" ){ echo " Op&eacute;rationnel tr&eacute;s prochainement ... ";  exit(); }
if ( ! mysql_connect($host, $user, $pass)  ){ echo " Op&eacute;rationnel tr&eacute;s prochainement ... ";  exit(); }
$dbb = mysql_select_db($base);
//mysql_set_charset('utf8',$dbb);
$date = date("d-m-Y");


$login = $_SESSION['_login1'] ;
$mdp = $_SESSION['_pass1'] ;




// ****************** securite d'envoi get et post *******************************************************************************************
$forbidden_strng=array("java","script","cookie","union","select","schema","count","<?");
for ($i=0; $i<=count($forbidden_strng); $i++){
    for ($ii=0; $ii<=count($_POST); $ii++){
        $posts=array_keys($_POST);
        if (strstr(strtolower($_SERVER[QUERY_STRING]),$forbidden_strng[$i]) || strstr(strtolower($_POST[$posts[$ii]]),$forbidden_strng[$i])){
			header("Location: ".$site);
        }
    }
}
// ****************** securite d'envoi get et post *******************************************************************************************





// PACK EN CONSTRUCTION //echo contenu_Table('t_parametres', 11, 4 );


$reqip = "SELEct * from t_comptes where ip='".getRealIpAddr()."'";
$envip = mysql_query($reqip);
$ddip = mysql_fetch_array($envip);
$ddip[0] = $ddip[0] + 0;

function UrlAdmin(){
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	if (strpos($url,'Admin') !== false) {
		return 1;
	} else {
		return 0;
	}	
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//echo $ddip[0];
//exit();
if (( contenu_Table('t_parametres', 11, 2 ) == 1 ) && ($session=='non') && ($ddip[0] == 0) && ($deconnect != 'oui') ) {
echo " <table height='100%' width='100%'><tr><td align='center'>
<img src='images/logoicone.png'><br>
<br>Op&eacute;rationnel tr&eacute;s prochainement ...<br><br><br><br></td></tr></table>";  exit();
}

// PACK EN CONSTRUCTION










// cryptage donnees


interface SAID{
	public function __construct($Key, $Algo = MCRYPT_BLOWFISH);
	public function Encrypt($data);
	public function Decrypt($data);
}

class SALAH implements SAID{
	private $Key;
	private $Algo;

	public function __construct($Key, $Algo = MCRYPT_BLOWFISH){
		$this->Key = str_pad(substr($Key, 0, mcrypt_get_key_size($Algo, MCRYPT_MODE_ECB)), 16, "\0", STR_PAD_RIGHT);
		$this->Algo = $Algo;
	}

	public function Encrypt($data){
		if(!$data){
			return false;
		}
		
		//Optional Part, only necessary if you use other encryption mode than ECB
		//$Key = str_pad($Key, 16, "\0", STR_PAD_RIGHT);
		
		$iv_size = mcrypt_get_iv_size($this->Algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$crypt = mcrypt_encrypt($this->Algo, $this->Key, $data, MCRYPT_MODE_ECB, $iv);
		return trim(base64_encode($crypt));
	}
	
	public function Decrypt($data){
		if(!$data){
			return false;
		}
		
		$crypt = base64_decode($data);
		
		//Optional Part, only necessary if you use other encryption mode than ECB
		$iv_size = mcrypt_get_iv_size($this->Algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$decrypt = mcrypt_decrypt($this->Algo, $this->Key, $crypt, MCRYPT_MODE_ECB, $iv);
		return trim($decrypt);
	
	}
	
}



function securite($string){
	if(ctype_digit($string)){
		$string = intval($string);
	}
	else{
		$string = mysql_real_escape_string($string);
		$string = addcslashes($string, '%_');
	}
	return $string;
}


function ajouter_activity($description){ 
//==================================================================================
		$id_compte = opensession_id(securite($_SESSION['_login1']),securite($_SESSION['_pass1']),0) ;
		$ip = get_ip();
		
		$timezone  = 0; //(GMT -5:00) EST (U.S. & Canada) 
		$dateact = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))); 
		                                                                             //======================= AJOUTER ACTIVITY  ============
				//--------------		$host='localhost';
		$reeact = " INSERT INTO ".$base.".`t_comptes_journal_activity` 
		(`num`, `description`, `id_compte`, `date`, `ip`) VALUES 
		(NULL, '".securite($description)."', '".$id_compte."','".$dateact."', '".$ip."' )";
		
		$eneact = mysql_query($reeact);
//==================================================================================
}

//======================================= DATE TIME ========================================
$tab_jours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
$a_mois_fr = array ( '1' => 'Janvier', '2' => 'Fevrier', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Aout', '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Decembre');
$jour = date("Y-m-d");
list($anneeJ,$moisJ,$jourJ) = sscanf($jour, "%d-%d-%d");
$jourSemaine=$tab_jours[date('w', mktime(0,0,0,$moisJ,$jourJ,$anneeJ))];
$hadnhar = $jourSemaine." ".date("d")." ".$a_mois_fr[intval(date("m"))]." ".date("Y");
//======================================= DATE TIME ========================================
function dateecrit($jour){
$tab_jours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
$a_mois_fr = array ( '1' => 'Janvier', '2' => 'Fevrier', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Aout', '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Decembre');
//$jour = date($jour, "Y-m-d");
list($anneeJ,$moisJ,$jourJ) = sscanf($jour, "%d-%d-%d");
$jourSemaine=$tab_jours[date('w', mktime(0,0,0,$moisJ,$jourJ,$anneeJ))];
$hadnhar = $jourSemaine." ".date("d")." ".$a_mois_fr[intval($moisJ)]." ".$anneeJ;
return $hadnhar;
}

//======= date to mktime =====================
function datetomktime($today){ // format 31/12/2016

       $month = intval(substr($today, 3, 2)) + 0;  
		$mday =  intval(substr($today, 0, 2)) + 0; 
        $year = intval(substr($today, 7, 4)) + 0;  
       $heur = intval(substr($today, 11, 2))  + 0;  
		$munite =  intval(substr($today, 14, 2)) + 0; 
        $second = intval(substr($today, 17, 2)) + 0;  

		$date_time = mktime($heur,$munite,$second,$month,$mday,$year);
		return $date_time;
}
//======= date to mktime =====================

function ajouter_zero($text, $nbrdemander){
$plop = strlen ($text);
		while ($plop<=$nbrdemander){
				$plop++;
				$text= "0".$text ;
		}
return 	$text ;	
}
function ajouter_plus($num){
$rrrr='';
if ($num>0){ $rrrr = '+'; } ;	
return $rrrr.sprintf('%01.2f',round($num,2)) ;
}

//******************	
function contenu_Table($tab, $num, $colonn)
{			
$req = "SELEct * from ".$tab." where num=".$num;
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[$colonn];
}
//******************	

//******************	
function champ_Table($tab, $num, $colonn,$nom_col )
{			
$req = "SELEct * from ".$tab." where ".$nom_col."=".$num;
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[$colonn];
}
//******************

//******************	
function Max_prix(  $produit )
{			
/* $reqaa = "SELEct prix from t_produits_entrez_sortie  where  id_produit=".$produit."  order by num desc";
$envaa = mysql_query($reqaa);
$ddaa=mysql_fetch_array($envaa);
return $ddaa[0] + 0; */
/*
$reqaa = "SELEct ( sum(prix*qt) / sum(qt) ) from t_produits_entrez_sortie  where type='e' and  id_produit=".$produit ;
$envaa = mysql_query($reqaa);
$ddaa=mysql_fetch_array($envaa);
$prix_v = $ddaa[0] + 0;
*/

$reqaa = "SELEct prix from t_produits  where num=".$produit ;
$envaa = mysql_query($reqaa);
$ddaa=mysql_fetch_array($envaa);
$prix_v = $ddaa[0] + 0;

return sprintf('%01.2f',round($prix_v,2));
}
//******************
//******************	
function QT_disp(  $produit )
{			
$reqaa = "SELEct sum(qt) from t_produits_entrez_sortie  where sup=0 and type='e' and id_produit=".$produit ;
$envaa = mysql_query($reqaa);
$ddaa=mysql_fetch_array($envaa);
$somm =  $ddaa[0] ;

$reqaa = "SELEct sum(qt-qt_rt) from t_produits_entrez_sortie  where sup=0 and id_cmd in( select num from t_clients_cmd where sup=0 ) and type='s' and id_produit=".$produit ;
$envaa = mysql_query($reqaa);
$ddaa = mysql_fetch_array($envaa);
$somm = $somm -  $ddaa[0] ;
return $somm ;
}
//******************
	
//******************	
function Total_cmd(  $num_cmd )
{			
$reqavvv = "SELEct sum(prix) from t_clients_cmd_prestation where sup=0 and cmd=".$num_cmd ;
$envavvv = mysql_query($reqavvv);
$ddavvv=mysql_fetch_array($envavvv);
$somm =  $ddavvv[0] ;

$reqavvv1 = "SELECT sum(qt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and id_cmd=".$num_cmd ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);
$somm = $somm +  $ddaq[0] ;
if ( champ_Table('t_clients_cmd', $num_cmd ,'produit_divers' ,'num' )!='' ){  $somm += champ_Table('t_clients_cmd', $num_cmd ,'produit_div_prix' ,'num' ); }

$tt_ht = $somm ;

$remise = champ_Table('t_clients_cmd', $num_cmd ,'remise' ,'num' ) ;

$ttal_ttc = $somm * ( 1 - ($remise/100) );

return $ttal_ttc ;
}
//******************	
//******************	
function detail_cmd(  $num_cmd )
{			
$reqavvv = "SELEct sum(prix) from t_clients_cmd_prestation where sup=0 and cmd=".$num_cmd ;
$envavvv = mysql_query($reqavvv);
$ddavvv=mysql_fetch_array($envavvv);
$somm =  $ddavvv[0] ;

$reqavvv1 = "SELECT sum(qt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and id_cmd=".$num_cmd ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);
$somm = $somm +  $ddaq[0] ;
if ( champ_Table('t_clients_cmd', $num_cmd ,'produit_divers' ,'num' )!='' ){  $somm += champ_Table('t_clients_cmd', $num_cmd ,'produit_div_prix' ,'num' ); }

$tt_ht = $somm ;

$remise = champ_Table('t_clients_cmd', $num_cmd ,'remise' ,'num' ) ;

$tva = $tt_ht * 0.2;


$tt_ht = $tt_ht- $tva ;

$ttal_ttc = $tt_ht * ( 1 - ($remise/100) );

return array( $ttal_ttc, $tva ,  ($tt_ht * $remise / 100) , $tt_ht) ;
}
//******************	


//******************	
function Total_cmd_avoir(  $num_cmd )
{			
$somm =  0 ;

$reqavvv1 = "SELECT sum(qt_rt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and id_cmd=".$num_cmd ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);
$somm = $somm +  $ddaq[0] ;
//$tt_ht = $somm ;

$remise = champ_Table('t_clients_cmd', $num_cmd ,'remise' ,'num' ) ;

$ttal_ttc = $somm * ( 1 - ($remise/100) )* 1.2;

return $ttal_ttc ;
}
//******************	

//******************	
function Total_cmdclient(  $datereg, $idclient ) /////////////////////// journal
{			
$reqavvv1_cmd = "select num from t_clients_cmd where id_client='".$idclient."' and sup=0 and  `fermer`=1 and date_time <= '".$datereg."'" ;
$envs1_cmd = mysql_query($reqavvv1_cmd);
$total_cmd1 = 0;
	while ($ddaq_cmd = mysql_fetch_array($envs1_cmd) ){
	$total_cmd1 +=  Total_cmd(  $ddaq_cmd[0] );
	} 
return $total_cmd1;
}
//******************	

//******************	
function Total_reglements(  $datereg, $idclient)
{			
$reqavvv1 = "SELECT sum(`MONTANT`) FROM `t_clients_reglements` WHERE sup=0 and  id_client='". $idclient."' and `date_time` <= '".$datereg."'" ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1); 
return $ddaq[0] ;
}
//******************	 /////////////////////// journal



//******************	
function Total_cmd_retour(  $num_cmd )
{			
$somm =  0;

$reqavvv1 = "SELECT sum(qt_rt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and id_cmd=".$num_cmd ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);
$somm = $somm +  $ddaq[0] ;
return $somm ;
}
//******************


//******************	
function Total_cmdclient_retour(  $datereg, $idclient )
{			
$reqavvv1 = "SELECT sum(qt_rt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and id_cmd in ( select num from t_clients_cmd where id_client='".$idclient."' and sup=0 and date_time <= '".$datereg."' )" ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1); 

return $ddaq[0] ;
}
//******************



//************************************************ solde client ***************************************
function solde_client($id){
$reqregss = "

( SELECT `num`,  `dateopr` as dateac , `date_time` as dateop ,  `type`, `num_cheque`,  `montant`  FROM `t_clients_reglements` where id_client='".$id."'  and sup=0  )
union 
( SELECT `num`,`date_cmd` as dateac , `date_time` as dateop ,  if( `fermer` = 1 , 'BL' , 'BL' ) as type  ,  if( `fermer` = 1 , 'BL' , 'BL' ) as num_cheque ,  num as montant FROM `t_clients_cmd` where id_client='".$id."' and fermer=1 and sup=0  )  order by dateop desc ";

$envs1ss = mysql_query($reqregss);
$cmdregss = mysql_fetch_array($envs1ss); 


return sprintf('%01.2f',round(Total_reglements(  $cmdregss['dateop'] , $id) - Total_cmdclient(  $cmdregss['dateop'] , $id)+ Total_cmdclient_retour(  $cmdregss['dateop'] ,$id),2));
}
//************************************************ solde client ***************************************




//******************	
function countrows( $tab, $cnd )
{			
$req = "SELEct count(num) from ".$tab." where sup=0 and ".$cnd ;
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[0]+0;
}
//******************	

function crypterpass($password,$loglog){
//============== cryptage passs =============================
//$password = "Test";
	$AMINE = new SALAH($loglog, MCRYPT_RIJNDAEL_256);
	$password = $AMINE->Encrypt($password);
	return $password;
//============== cryptage passs =============================
}

function opensession($login, $password){
 $password = crypterpass($password,id_login($login));

$req = "SELECT *
FROM `t_comptes`
WHERE `login` = '".$login."'
AND `password` = '".$password."' and sup=0";
$env = mysql_query($req);
$dd=mysql_fetch_array($env);

return $dd[3]; 
}

function opensession_id($login, $password, $coll){
 $password = crypterpass($password,id_login($login));
$req = "SELECT *
FROM `t_comptes`
WHERE `login` = '".$login."'
AND `password` = '".$password."'";
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[$coll]; 
}

function id_login($login){
$req = "SELECT *
FROM `t_comptes`
WHERE `login` = '".$login."'";
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[0]; 
}

function get_ip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}

function autorisation($type, $nom_zone){
$req = "SELECT *
FROM `t_comptes_access`
WHERE `type_compte` = '".$type."'
AND `nom_zone` = '".$nom_zone."'";
$env = mysql_query($req);
$dd=mysql_fetch_array($env);
return $dd[0]; 
}
?>


<?php //==================== si avec session ==============
if ($session=='oui'){ 
	if ( isset($_SESSION['_login1']) && isset($_SESSION['_pass1']) ){
	if ( securite($_SESSION['_login1'])=='' || securite($_SESSION['_pass1'])=='' )
    {
        include("./form.php");
		echo "Connectez vous pour avoir un accee a cet page";
        exit();
    }


   if ( opensession(securite($_SESSION['_login1']),securite($_SESSION['_pass1']))=="")
    {
        $msg ='<p><b style="color:red">- Votre connexion ne semble pas valide</b></p>';
		//echo $msg;
        include("./form.php");
        exit();
    } else { 
	// echo '<a href="deconnecter.php">deconnecter</a>';
    }
	}else{
	
		echo '<p style="background-color:#F5F6F7;"><b style="color:red; font-size:10px;">SVP, connectez-vous</b></p>';
        include("./form.php");
        exit();
    }
}

FUNCTION CONVERTdateFORMAT($today){ // convert 2014-01-02 to 02/01/2014
        //$today =  $_GET['datepicker1'];  
		
        $month = substr($today, 5, 2) ;  
		$mday =  substr($today, 8, 2); 
        $year = substr($today, 0, 4);  
		//if ( $mday<10 ) { $mday = '0'.$mday ; }
		//if ( $month<10 ) { $month = '0'.$month ; }
        $date11 =$mday . "/" . $month . "/" . $year;   
		return $date11;
}
FUNCTION CONVERTdateFORMAT2($today){ // convert  02/01/2014 to 2014-01-02
        //$today =  $_GET['datepicker1'];  
		
        $month = substr($today, 3, 2) ;  
		$mday =  substr($today, 0, 2); 
        $year = substr($today, 6, 4);  
		if ( $mday<10 ) { $mday = '0'.$mday ; }
		if ( $month<10 ) { $month = '0'.$month ; }
        $date11 = $year . "-" . $month . "-" . $mday;   
		return $date11;
}
FUNCTION reCONVERTdateFORMAT($today){
        //$today =  $_GET['datepicker1'];  
		
        $month = substr($today, 3, 2) ;  
		$mday =  substr($today, 0, 2); 
        $year = substr($today, 6, 4);  
		//if ( $mday<10 ) { $mday = '0'.$mday ; }
		//if ( $month<10 ) { $month = '0'.$month ; }
        $date11 =$mday . "/" . $month . "/" . $year;   
		return $date11;
}


FUNCTION som_prestation($mois,$an,$idpersonnel){

$req44 = "SELEct sum(avance) from ".$base.".T_personnel_av_salaire where sup=0 and personnel= ".$idpersonnel." and mois=".$mois." and annee=".$an;
$env44 = mysql_query($req44);
$cmd44=mysql_fetch_array($env44);
 
		return $cmd44[0];
		
}

FUNCTION chiffreaffaire($ann, $mois,$sevice){
		
		$cndsql = $ann."-";
		if( $mois > 0 ) { 
		if( $mois < 10 ) { $mois = "0".$mois; }
		$cndsql = $cndsql.$mois; }
		
$req00 = "SELEct sum(prix) from t_clients_cmd_prestation  where   sup=0 and dateopr like '%".$cndsql."%' and id_prestation in ( SELECT num FROM `t_prestation` WHERE `id_service` = ".$sevice."  )" ;
$env00 = mysql_query($req00);
$cmd400 = mysql_fetch_array($env00);

		return $cmd400[0]+0;
		
}



FUNCTION totalvente($ann, $mois ){ 
		
		$cndsql = $ann."-";
		if( $mois > 0 ) { 
		if( $mois < 10 ) { $mois = "0".$mois; }
		$cndsql = $cndsql.$mois; }

$reqavvv1 = "SELECT sum(qt*prix) FROM `t_produits_entrez_sortie` WHERE type='s' and sup=0 and date_operation like '%".$cndsql."%' and id_cmd in ( SELECT num FROM `t_clients_cmd` WHERE `fermer`=1  and sup=0 ) " ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);

$reqavvv1_cmd = "select num from t_clients_cmd where sup=0 and  `fermer`=1 and date_cmd  like '%".$cndsql."%'  " ;
$envs1_cmd = mysql_query($reqavvv1_cmd);
$total_cmd1 = 0;
	while ($ddaq_cmd = mysql_fetch_array($envs1_cmd) ){
	$total_cmd1 +=  Total_cmd(  $ddaq_cmd[0] )-Total_cmd_avoir(  $ddaq_cmd[0] );
	} 
return $total_cmd1;
}

FUNCTION totaldepense($ann, $mois ){ 
		
		$cndsql = "/".$ann;
		if( $mois > 0 ) { 
		if( $mois < 10 ) { $mois = "0".$mois; }
		$cndsql = $mois.$cndsql; }

$reqavvv1 = "SELECT sum(total) FROM `t_depenses` WHERE  sup=0 and dateopr like '%".$cndsql."%'  " ;
$envs1 = mysql_query($reqavvv1);
$ddaq = mysql_fetch_array($envs1);

return $ddaq[0];
}


FUNCTION totalreste($datecmd , $idclient){
		


$reqavvv22 = "SELECT * FROM `t_clients_cmd` WHERE fermer=1 and `date_cmd` <= '".$datecmd."' and id_client='". $idclient."' " ;
$envs22 = mysql_query($reqavvv22);
$tot = 0;
		while ( $ddaS=mysql_fetch_array($envs22)){ 
		$tot = $tot + Total_cmd($ddaS[0]);
		}

return  $tot ;

}



//====================================== STOCKS +++++++++++++++++++++++++++++++++++++++++


			FUNCTION stock_som_prix_total( $idstock ){ 
			
			$reqavvv1 = "SELECT sum(qt*prixstockachat) FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1 = mysql_query($reqavvv1);
			$ddaq = mysql_fetch_array($envs1);
			
			return $ddaq[0]+0;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_qt( $idstock ){ 
			
			$reqavvv1 = "SELECT sum(qt) FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1 = mysql_query($reqavvv1);
			$ddaq = mysql_fetch_array($envs1);
			
			return $ddaq[0]+0;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_fret( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$sommm += $fretx ;
					
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_prix_u_rcasa( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$sommm += $pucasax;
					
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_prix_total_rcasa( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					$sommm += $pttcasax;
					
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_frais_financiers( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					$fraisfinanx = ($pttcasax/stock_som_prix_total_rcasa( $stocksx[0] ))*$stocksx['Frais_financiers'] ;
					$sommm += $fraisfinanx;
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_frais_propre( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					$fraisfinanx = ($pttcasax/stock_som_prix_total_rcasa( $stocksx[0] ))*$stocksx['Frais_financiers'] ;
					$fraisproprex = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['Fraispropre'] ;
					$sommm += $fraisproprex;
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_frais_transport( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					$fraisfinanx = ($pttcasax/stock_som_prix_total_rcasa( $stocksx[0] ))*$stocksx['Frais_financiers'] ;
					$fraisproprex = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['Fraispropre'] ;
					$fraistransx = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['frais_transport'] ; 
					$sommm += $fraistransx;
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_drt( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					//$fraisfinanx = ($pttcasax/stock_som_prix_total_rcasa( $stocksx[0] ))*$stocksx['Frais_financiers'] ;
					//$fraisproprex = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['Fraispropre'] ;
					//$fraistransx = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['frais_transport'] ; 
					$drtx = ($pttcasax)*$ddaq_cmd['drt_taxe']/100 ;
					$sommm += $drtx;
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------
			FUNCTION stock_som_coutrevien( $idstock ){ 
			
				$reqx = "SELEct * from t_stock_parametres where num=  ".$idstock." order by num desc" ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				
			$sommm = 0;
			
			$reqavvv1x = "SELECT * FROM `t_produits_entrez_sortie` WHERE idstock=".$idstock." and sup=0  " ;
			$envs1x = mysql_query($reqavvv1x);
			
					while ($ddaq_cmd = mysql_fetch_array($envs1x) ){
					
					$fretx = (($stocksx['Fret']/$stocksx['TAUX_BANCAIRES'])/stock_som_qt( $stocksx[0] ))*$ddaq_cmd['qt'];
					$pucasax = ((($ddaq_cmd['prixstockachat']*$ddaq_cmd['qt'])+$fretx)*$stocksx['TAUX_BANCAIRES'])/$ddaq_cmd['qt']; 
					$pttcasax = $pucasax*$ddaq_cmd['qt'];
					$fraisfinanx = ($pttcasax/stock_som_prix_total_rcasa( $stocksx[0] ))*$stocksx['Frais_financiers'] ;
					$fraisproprex = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['Fraispropre'] ;
					$fraistransx = ($ddaq_cmd['qt']/stock_som_qt( $stocksx[0] ))*$stocksx['frais_transport'] ; 
					$drtx = ($pttcasax)*$ddaq_cmd['drt_taxe']/100 ;
					$coutrevienx = ($pttcasax + $fraisfinanx +  $fraisproprex + $fraistransx + $drtx) ;
					$sommm += $coutrevienx;
					} 
			
			return $sommm ;
			}
			//-------------------------------------------------------------------


//====================================== STOCKS +++++++++++++++++++++++++++++++++++++++++


function int2str($a){ 
$joakim = explode('.',$a); 
if (isset($joakim[1]) && $joakim[1]!=''){ 
return int2str($joakim[0]).' virgule '.int2str($joakim[1]) ; 
} 
if ($a<0) return 'moins '.int2str(-$a); 
if ($a<17){ 
switch ($a){ 
case 0: return 'zero'; 
case 1: return 'un'; 
case 2: return 'deux'; 
case 3: return 'trois'; 
case 4: return 'quatre'; 
case 5: return 'cinq'; 
case 6: return 'six'; 
case 7: return 'sept'; 
case 8: return 'huit'; 
case 9: return 'neuf'; 
case 10: return 'dix'; 
case 11: return 'onze'; 
case 12: return 'douze'; 
case 13: return 'treize'; 
case 14: return 'quatorze'; 
case 15: return 'quinze'; 
case 16: return 'seize'; 
} 
} else if ($a<20){ 
return 'dix-'.int2str($a-10); 
} else if ($a<100){ 
if ($a%10==0){ 
switch ($a){ 
case 20: return 'vingt'; 
case 30: return 'trente'; 
case 40: return 'quarante'; 
case 50: return 'cinquante'; 
case 60: return 'soixante'; 
case 70: return 'soixante-dix'; 
case 80: return 'quatre-vingt'; 
case 90: return 'quatre-vingt-dix'; 
} 
} elseif (substr($a, -1)==1){ 
if( ((int)($a/10)*10)<70 ){ 
return int2str((int)($a/10)*10).'-et-un'; 
} elseif ($a==71) { 
return 'soixante-et-onze'; 
} elseif ($a==81) { 
return 'quatre-vingt-un'; 
} elseif ($a==91) { 
return 'quatre-vingt-onze'; 
} 
} elseif ($a<70){ 
return int2str($a-$a%10).'-'.int2str($a%10); 
} elseif ($a<80){ 
return int2str(60).'-'.int2str($a%20); 
} else{ 
return int2str(80).'-'.int2str($a%20); 
} 
} else if ($a==100){ 
return 'cent'; 
} else if ($a<200){ 
return int2str(100).' '.int2str($a%100); 
} else if ($a<1000){ 
if($a%100==0) 
return int2str((int)($a/100)).' '.int2str(100); 
if($a%100!=0)return int2str((int)($a/100)).' '.int2str(100).' '.int2str($a%100); 
} else if ($a==1000){ 
return 'mille'; 
} else if ($a<2000){ 
return int2str(1000).' '.int2str($a%1000).' '; 
} else if ($a<1000000){ 
return int2str((int)($a/1000)).' '.int2str(1000).' '.int2str($a%1000); 
} 
} 



//================================= FOURNISSEURS ==================================================
function fournisseur_nbr_qt_cmd($numcmd){
	
				$reqx = "SELECT sum(`qt`) FROM `t_fournisseurs_cmd_detail` WHERE `id_cmd`=".$numcmd ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				return $stocksx[0] + 0;
}
//================================= FOURNISSEURS ==================================================

//================================= FOURNISSEURS ==================================================
function fournisseur_nbr_prd_cmd($numcmd){
	
				$reqx = "SELECT count(`num`) FROM `t_fournisseurs_cmd_detail` WHERE `id_cmd`=".$numcmd ;
				$envx = mysql_query($reqx);
				$stocksx = mysql_fetch_array($envx);
				return $stocksx[0] + 0;
}
//================================= FOURNISSEURS ==================================================

function mois_date($num){
$french_months = array('Janvier', 'F&#233;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&#251;t', 'Septembre', 'Octobre', 'Novembre', 'D&#233;cembre');
return 	$french_months[$num-1];
}


function detaildate($format) {
//        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
 //       $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Décember');
        $french_months = array('Janvier', 'F&#233;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&#251;t', 'Septembre', 'Octobre', 'Novembre', 'D&#233;cembre');
   
$detaildate =  explode('/',$format);
$detaildate['jour'] = $french_days[ $detaildate[0] ] ;
$detaildate['mois'] = $french_months[ intval($detaildate[1])-1 ] ;
        return $detaildate;
}


// ******************************************************************** Albums photo
function albums_photos($dossierphoto,$nom_alb,$h_vign,$l_vign){
echo '<div class="image-row" ><div class="image-set">';
// nom du répertoire qui contient les images
$nomRepertoire = $dossierphoto; 
//echo $nomRepertoire;
if (is_dir($nomRepertoire))
   {
  // echo $nomRepertoire;
   $dossier = opendir($nomRepertoire);
   while ($Fichier = readdir($dossier))
       {
      if ($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp')))
        {
        // Hauteur de toutes les images
        //$h_vign = "110";
        $taille = getimagesize($nomRepertoire."/".$Fichier);
        $reduc  = floor(($h_vign*100)/($taille[1]));
        //$l_vign = "224";//floor(($taille[0]*$reduc)/100);
		//echo "salam";
          echo '<span style="float:left;" id="'.basename($Fichier,".JPG").'"><a target="_blank" href="#" onclick=\'imgdefault("' ,$Fichier, '","', $nomRepertoire ,'"); return false; \' >';
          echo '<img src="', $nom_alb, '/',   'tn_'.$nomRepertoire, '/',$Fichier, '"   class="'.$nom_alb.'" alt=""';
          echo " height='$h_vign'  rel='prettyPhoto[image_map]' >";
          echo '</a>&nbsp;<br> <a href=\'#\' onclick=\'supprimer_photo("',   $nomRepertoire, '/',$Fichier, '"); return false;\' style=\' text-decoration:none; font-size:10px;\'>SUPRIMER</a></span>';
          }
        }    
   closedir($dossier);
   }else{
   echo '' ;
   }
echo '</div></div>';
					
}
// ******************************************************************** Albums photo

// ******************************************************************** Albums photo
function albums_1photos($dossierphoto,$nom_alb,$h_vign,$l_vign){ 
$nomRepertoire = $dossierphoto; 
//echo $nomRepertoire;
if (is_dir($nomRepertoire))
   {
  // echo $nomRepertoire;
   $dossier = opendir($nomRepertoire);
   $nomfichier = "";
   while (($Fichier == readdir($dossier)) && ($nomfichier=="") )
      {
      if ($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp')))
        { 
		$nomfichier = $Fichier ;
        }
      }    
   closedir($dossier);
   }  
					
}
// ******************************************************************** Albums photo
function motstext($textmots , $nbrmots ){
	$tabstr = explode( " ", $textmots );
	$i = 0;
	while ( $i < $nbrmots ){
		$motstext .= $tabstr[$i]." " ;
		$i += 1 ;
	}
	return $motstext;
}

function substrmot($str, $nbrmot)
{

if (strpos($str, ' ', $nbrmot) !== false)
    {
     return substr($str, 0, strpos($str, ' ', $nbrmot));
    }
    else
    {
        // Il n’y a pas d’espace après 300 caractères, à toi de voir ce qu’on fait dans ce cas.
		return $str;
    }
	
}	

function html2text($Document) {
    $Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&(reg|#174);@i',
                    '@&#(d+);@e'
             );
    $Replace = array ('',
                      '',
                      '',
                      '',
                      '&',
                      '<',
                      '>',
                      ' ',
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      chr(174),
                      'chr()'
                );
  return preg_replace($Rules, $Replace, $Document);
}

?>

<?php		
function listeimagedossier($num,$perimg){
$eliminer1erimage = $perimg+0;
$nomRepertoire = "Admin/accueil/tn_".$num;
if (is_dir($nomRepertoire))
   {
   $dossier = opendir($nomRepertoire);
  // $dossier = asort($dossier);
   while ($Fichier = readdir($dossier))
       {
      if ($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp'))   )
        {
			 if ( $eliminer1erimage == 1 ){
			
        // Hauteur de toutes les images
        //$h_vign = "110";
        $taille = getimagesize($nomRepertoire."/".$Fichier);
        $reduc  = floor(($h_vign*100)/($taille[1]));
        //$l_vign = "224";//floor(($taille[0]*$reduc)/100);
?>



<a class="example-image-link" href="<?php echo str_replace("tn_","",$nomRepertoire),'/',$Fichier; ?>" data-lightbox="article-<?php echo $num; ?>" data-title=""  ><img class="list-image autoopacityimg"  src="<?php echo $nomRepertoire,'/',$Fichier; ?>" alt=""  style=" height:40px;
    border: solid 6px #efecec;" onMouseOver="$( this ).animate({
			opacity: 0.4
		  }, 400 );" onMouseOut="$( this ).animate({
			opacity: 1
		  }, 400 );"></a>

			  		 
 <?php    
          
			 } else { $eliminer1erimage = 1; }
		 } 
        }    
		
		
   closedir($dossier);
   } 
} // fin funct listeimage
		?>	




<?php		
function imagedossier($num){

$nomRepertoire = "Admin/accueil/tn_".$num;
if (is_dir($nomRepertoire))
   {
   $dossier = opendir($nomRepertoire);
  // $dossier = asort($dossier);
   while (($Fichier = readdir($dossier)) && $arret == 0)
       {
      if ($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp')))
        {
        // Hauteur de toutes les images
        //$h_vign = "110";
        $taille = getimagesize($nomRepertoire."/".$Fichier);
        $reduc  = floor(($h_vign*100)/($taille[1]));
        //$l_vign = "224";//floor(($taille[0]*$reduc)/100);
?>


<a class="example-image-link" href="<?php echo str_replace("tn_","",$nomRepertoire),'/',$Fichier; ?>" data-lightbox="article-<?php echo $num; ?>" data-title=""><img  onMouseOver="$( this ).animate({
			opacity: 0.4
		  }, 400 );" onMouseOut="$( this ).animate({
			opacity: 1
		  }, 400 );" src="<?php echo str_replace("tn_","",$nomRepertoire),'/',$Fichier; ?>" width="100%"></a>


			  		 
 <?php     $arret = 1;
          }
        }    
		
		
   closedir($dossier);
   } 
} // fin funct listeimage



//***************** 	afficher les num de page exp: precedent 1.2.3 ... suivant  
//----------------------------------------------------
function Afficher_page_num( $nbr_p_par_page, $pageencours, $nbr_produit_globale, $site ,$adress ) 
			{ 		
			echo "<table border='0'><tr>";
			//..........................................
			$div = intval($nbr_produit_globale/$nbr_p_par_page);								//...... le Div
			$reste = $nbr_produit_globale- intval($nbr_produit_globale/$nbr_p_par_page)*$nbr_p_par_page;		//...... le reste
			if ($reste >0) { $div=$div+1;}
			//------------------------------------------
			$ii=1;
			if  ( 1 == $pageencours) { echo "<td align='center' valign='middle'> </td>"; } else { echo "<td align='center' valign='middle'> <a class='lien_menus' href='".$site."accueil.php?page=".($pageencours-1).$adress."' title='page precedent n° ".($pageencours-1)."'><img src='images/img-prod-prec.gif'></a> </td>"; } //precedent
			//----------------
			while ( $ii<= $div)
			{
			if ( $ii < 10) { $nii = "0".$ii; } else {$nii = $ii; }
			if ( $ii== $pageencours) { echo "<td align='center' valign='middle'> ".$nii."  </td> "; } else { echo "<td align='center' valign='middle'>  <a class='lien_menus'  href='".$site."accueil.php".$adress."&page=".$ii."' title='page n° ".$ii."' >".$nii."</a>  </td>"; }
			$ii= $ii +1;
			}
			//----------------
			if  ( ($div == $pageencours) or (($pageencours == 1) and ($nbr_produit_globale < $nbr_p_par_page )) ) { echo "<td align='center' valign='middle'> </td>"; } else { echo "<td align='center' valign='middle'> <a class='lien_menus'  href='".$site."accueil.php".$adress."&page=".($pageencours + 1)."' title='page suiavnt n° ".($pageencours + 1)."' ><img src='images/img-prod-suiv.gif'></a> </td>"; } //suiavnt
			echo "</tr></table>";
			}
//----------------------------------------------------



		?>	