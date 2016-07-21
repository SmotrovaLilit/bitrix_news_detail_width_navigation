<?php
namespace WsTemplate;

use Bitrix\Main\Loader;

class Navigation
{
    protected $next_element;
    protected $prev_element;
    
    private $arParams = array();
    
    private $cicle = false;

    public function prepareParams($arParams)
    {
        $arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
        if(strlen($arParams["SORT_BY1"])<=0)
            $arParams["SORT_BY1"] = "ACTIVE_FROM";
        if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
            $arParams["SORT_ORDER1"]="DESC";

        if(strlen($arParams["SORT_BY2"])<=0)
            $arParams["SORT_BY2"] = "SORT";
        if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]))
            $arParams["SORT_ORDER2"]="ASC";
        
        return $arParams;
    }
    
    public function __construct($arParams, $elementId, $cicle = false)
    {
        $this->arParams = self::prepareParams($arParams);
        $this->elementId = $elementId;
        $this->cicle = $cicle;
        
        $this->run();
    }

    public function getFilter()
    {
        $filter = array();
        if(strlen($this->arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $this->arParams["FILTER_NAME"]))
        {
            $filter = array();
        }
        else
        {
            $arrFilter = $GLOBALS[$this->arParams["FILTER_NAME"]];
            if(!is_array($arrFilter))
                $filter = array();
        }
        
        return array_merge(array (
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "IBLOCK_LID" => SITE_ID,
            "ACTIVE" => "Y",
            "CHECK_PERMISSIONS" => $this->arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
            "ACTIVE_DATE" => $this->arParams['CHECK_DATES'] == "Y" ? "Y" : "N",
        ), $filter);
    }

    public function getNextElement()
    {
        return $this->next_element;
    }
    
    public function getPrevElement()
    {
        return $this->prev_element;
    }

    private function run()
    {
        Loader::includeModule("iblock");
        
        $order = $this->getOrder();
        $order_inverse = $this->getOrderInverse();
        $resultFilter = $this->getFilter();
        
        $select = array();

        $rs = \CIBlockElement::GetList(
            $order,
            $resultFilter,
            false,
            array(
                "nElementID" => $this->elementId,
                "nPageSize"=>1),
            $select
        );
        $page = array();
        while($ar = $rs->GetNext())
        { $page[] = $ar; }

        if (count($page) == 2 && $this->elementId == $page[0]["ID"]){
            $this->next_element = $page[1];
            
            if ($this->cicle) {
                $rs = \CIBlockElement::GetList(
                    $order_inverse,
                    $resultFilter,
                    false,
                    array("nTopCount"=>1),
                    $select
                );

                if($ar = $rs->GetNext()) {
                    $this->prev_element = $ar;
                }                
            }

        }
        elseif (count($page) == 3){
            $this->next_element = $page[2];
            $this->prev_element = $page[0];
        }
        elseif (count($page) == 2 && $this->elementId == $page[1]["ID"]){
            $this->prev_element = $page[0];
            
            if ($this->cicle) {
                $rs = \CIBlockElement::GetList(
                    $order,
                    $resultFilter,
                    false,
                    array("nTopCount" => 1),
                    $select
                );

                if ($ar = $rs->GetNext()) {
                    $this->next_element = $ar;
                }
            }
        }
    }

    private function getOrder()
    {
        $arParams = $this->arParams;
        
        return array(
            $arParams["SORT_BY1"] => $arParams["SORT_ORDER1"],
            $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"],
        );
    }

    private function getOrderInverse()
    {
        $arParams = $this->arParams;

        return array(
            $arParams["SORT_BY1"] => (strtoupper($arParams["SORT_ORDER1"]) == 'ASC') ? 'DESC' : 'ASC',
            $arParams["SORT_BY2"] => (strtoupper($arParams["SORT_ORDER1"]) == 'ASC') ? 'ASC' : 'DESC',
        );
    }
}