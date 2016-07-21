<? use WS\Entity\News;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-detail">
	<? if ($arResult["PREV_ELEMENT"]) : ?>
		<a href="<?=$arResult["PREV_ELEMENT"]["DETAIL_PAGE_URL"]?>">prev</a>
	<? endif; ?>
	<? if ($arResult["NEXT_ELEMENT"]) : ?>
		<a href="<?=$arResult["NEXT_ELEMENT"]["DETAIL_PAGE_URL"]?>">next</a>
	<? endif; ?>
		
	<h1><?=$arResult[News::FIELD_NAME];?></h1>
	<? if ($arResult[News::FIELD_PREVIEW_PICTURE]["SRC"]) : ?>
		<img src="<?=$arResult[News::FIELD_PREVIEW_PICTURE]["SRC"]; ?>">
	<?endif;?>
	<?=$arResult[News::FIELD_DETAIL_TEXT];?>
</div>