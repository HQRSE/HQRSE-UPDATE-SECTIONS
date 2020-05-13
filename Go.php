<?
/*
HQRSE UPDATE SECTIONS
*********************
Delete last symbol. Example "_"
*********************

Stable from 13.05.2020
*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UpDeadMySections");
?>

<div class="container" style="margin-top: 200px;">

<?

define("NEED_AUTH", true);
global $USER;
if (!$USER->IsAdmin()) LocalRedirect("/");
 
set_time_limit(600);
$IBLOCK_TYPE = '1c_catalog';
 
# функция для замены символа "_" на "-"
function repSymCode($code){
	// if(strripos($code, '_')!==false){
	//$code = str_replace('_','-',$code);
	$lastsymbol = $code{strlen($code)-1};

	if($lastsymbol == '_') {
	$code = substr($code, 0, -1);
	//$code = str_replace('_','',$last_sym);
	//$code = substr($code,0,(strlen($code) - 1));
    return $code;
    } else return false;
}
 
# кнопка старт
if (isset($_REQUEST['start']) && CModule::IncludeModule("iblock")){
 
#------------------------------
# Update sections codes
#------------------------------
$sectionRes = CIBlockSection::GetList(
        array("SORT"=>"ASC"),
        array('IBLOCK_TYPE' => $IBLOCK_TYPE),
        false,
        array('CODE','ID'),
        false
);
$siCnt=0;
$secObj = new CIBlockSection;
while($arSection = $sectionRes->GetNext()){
    $code = repSymCode($arSection['CODE']);
    if ($code != false){
        $siCnt++;
        $secObj->Update($arSection['ID'], array('CODE' => $code));
    }
}
$arResult['MSG'][] = 'Обновлено разделов: '.$siCnt;
#-------------------------------
 
 
} # end if
?>
 
<h2>Замена символов в символьных кодах</h2>
<?if (count($arResult['MSG'])>0){
    foreach($arResult['MSG'] as $msgValue){?><p><?=$msgValue?></p><?}
}?>
<form method="post"><input type="submit" name="start" value="Старт"></form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


?>

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
