<?php 
use WsTemplate\Navigation;

require_once __DIR__ . '/lib/Navigation.php';


$navigation = new Navigation($arParams, $arResult["ID"]);
$arResult["NEXT_ELEMENT"] = $navigation->getNextElement();
$arResult["PREV_ELEMENT"] = $navigation->getPrevElement();

if (\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->get("clear_cache") == "Y") {
    CIBlock::clearIblockTagCache($arParams['IBLOCK_ID']);
}
