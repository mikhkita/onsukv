<?
namespace Sale\Handlers\Delivery;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;

class RussianHandler extends Base
{
    public static function getClassTitle()
        {
            return "Доставка почтой";
        }
        
    public static function getClassDescription()
        {
            return "";
        }
        
    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
        {
            $result = new CalculationResult();

            if( isset($_REQUEST["DELIVERY_PRICE"]) ){
                $price = floatval($_REQUEST["DELIVERY_PRICE"]);
            }else{
                $price = floatval($this->config["MAIN"]["PRICE"]);
            }
            // $weight = floatval($shipment->getWeight()) / 1000;
        
            $result->setDeliveryPrice($price);
            // $result->setPeriodDescription('1 день');
        
            return $result;
        }
        
    protected function getConfigStructure()
        {
            return array(
                "MAIN" => array(
                    "TITLE" => 'Настройки',
                    "DESCRIPTION" => 'Настройки',
                    "ITEMS" => array(
                        "PERIOD" => array(
                            "TYPE" => "NUMBER",
                            "MIN" => 0,
                            "NAME" => "Срок доставки"
                        ),
                        "PRICE" => array(
                            "TYPE" => "STRING",
                            "MULTILINE" => "Y",
                            "ROWS" => "20",
                            "COLS" => "50",
                            "NAME" => "Стоимость",
                            "DEFAULT" => ""
                        ),
                    )
                )
            );
        }
        
    public function isCalculatePriceImmediately()
        {
            return true;
        }
        
    public static function whetherAdminExtraServicesShow()
        {
            return true;
        }
}