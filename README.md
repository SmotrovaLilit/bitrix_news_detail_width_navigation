# Листание списка новостей на детальной

### В шаблоне компонента создаем дополнительные параметры для навигации
```
$arSorts = array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
    "ID"=>GetMessage("T_IBLOCK_DESC_FID"),
    "NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
    "ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
    "SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
    "TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
);
$arTemplateParameters = array(
    "SORT_BY1" => Array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
        "TYPE" => "LIST",
        "DEFAULT" => "ACTIVE_FROM",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "SORT_ORDER1" => Array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
        "TYPE" => "LIST",
        "DEFAULT" => "DESC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "SORT_BY2" => Array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage("T_IBLOCK_DESC_IBORD2"),
        "TYPE" => "LIST",
        "DEFAULT" => "SORT",
        "VALUES" => $arSortFields,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "SORT_ORDER2" => Array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage("T_IBLOCK_DESC_IBBY2"),
        "TYPE" => "LIST",
        "DEFAULT" => "ASC",
        "VALUES" => $arSorts,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "FILTER_NAME" => array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage("T_IBLOCK_FILTER"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
);

```

### Вызов компонента
В вызов компонента добавляем созданные параметры шаблона
```
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "DATE_CREATE",
	"SORT_ORDER2" => "DESC",
	"FILTER_NAME" => "newsFilter",

```


### В result_modifier.php

Формируем  навигацию

```
<?php 
use WsTemplate\Navigation;

require_once __DIR__ . '/lib/Navigation.php';


$navigation = new Navigation($arParams, $arResult["ID"]);
$arResult["NEXT_ELEMENT"] = $navigation->getNextElement();
$arResult["PREV_ELEMENT"] = $navigation->getPrevElement();


```

