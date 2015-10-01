<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\LegoSet;
use app\models\Store;
use app\models\StoreImport;
use app\models\StoreSet;
use app\models\StoreSetPrice;
use app\models\Theme;
use yii\console\Controller;
use yii\db\Expression;

class ScraperController extends Controller
{
    private $store_id;

    public $debug = false;
    public function options($actionID)
    {
        // $actionId might be used in subclasses to provide options specific to action id
        return ['debug'];
    }
    public function actionOutput()
    {
        $raw_input = '';
        while (!feof(STDIN)){
            $content = fgets(STDIN, 1024);
            $raw_input .= $content;
            $json = json_decode($content, TRUE);
            if ($json) {
                try {
                    $this->processLine($json);
                } catch (\Exception $e) {
                    // do something with the exception ...
                }
            } else {
                // bad json
            }

        }
        if ($this->store_id) {
            $storeImport = new StoreImport();
            $storeImport->store_id = $this->store_id;
            $storeImport->created_at = new Expression('NOW()');
            $storeImport->raw_data = $raw_input;
            $storeImport->save();
        }
        echo "\n";
    }

    public function actionUpdate() {
        $startYear = 2011;
        $endYear = date('Y');

        for($i = $startYear; $i <= $endYear; $i ++) {
            $url = 'http://brickset.com/api/v2.asmx/getSets?apiKey=tizB-rqbL-rIXo&userHash=&query=&theme=&subtheme=&setNumber=&year='.$i.'&owned=&wanted=&orderBy=&pageSize=1000&pageNumber=1&userName=';
            $data = file_get_contents($url);
            file_put_contents('brickset_'.$i.'.xml', $data);
            $this->parseXML($data);
        }
        //$data = file_get_contents(__DIR__.'/test.xml');

    }
    private function parseXML($xml)
    {
        $themes = [];
        $data = new \SimpleXMLElement($xml);
        foreach($data as $set) {
            $legoSet = LegoSet::findSet((string) $set->number);
            if ($legoSet) {

                $legoSet->title = (string) $set->name;
                $legoSet->year = (string) $set->year;
                if ($set->largeThumbnailURL) {
                    $legoSet->thumbnail_url = (string) $set->largeThumbnailURL;
                }
                $legoSet->brickset_url = (string) $set->bricksetURL;
                if ($set->theme) {
                    $theme_string = (string) $set->theme;
                    if (!isset($themes[$theme_string])) {
                        $theme = Theme::find()->where(['description' => $theme_string])->one();
                        if (!$theme) {
                            $theme = new Theme;
                            $theme->description = $theme_string;
                            $theme->save();
                        }
                        $themes[$theme->description] = $theme->id;
                    }

                    $legoSet->theme_id = $themes[$theme_string];
                }
                $legoSet->save();
            }
        }
    }
    private function processLine($json)
    {
        if ($json['set_id']) {
            echo $this->debug === false ? "" : $json['set_id'].' '.$json['title']."\n";
            $set = LegoSet::findSet($json['set_id']);
            if (!$set) {
                $set = new LegoSet();
                $set->title = substr($json['title'], 0, 100);
                $set->code = $json['set_id'];
                if (!$set->save()) {
                    // do something
                    echo $this->debug === false ? "" : " - New set .. ERROR unable to save ".json_encode($set->errors)."\n";
                } else {
                    echo $this->debug === false ? "" : " - New set saved\n";
                }
            }
            echo $this->debug === false ? "" : " - Store ".$json['store']."\n";
            $store = Store::findStore($json['store']);
            if (!$store) {
                $store = new Store();
                $store->title = ucfirst($json['store']);
                $store->hash = $json['store'];
                $store->save();
                echo $this->debug === false ? "" : " - new store, saved\n";
            }
            $this->store_id = $store->id;
            $store_set = StoreSet::findSet($store, $set);
            if (!$store_set) {
                $store_set = new StoreSet();
                $store_set->store_id = $store->id;
                $store_set->legoset_id = $set->id;
                $store_set->url = $json['link'];
                if (!$store_set->save()) {
                    // do something
                    echo $this->debug === false ? "" : " - new store set, ERROR -- not saved ".json_encode($store_set->errors)."\n";
                } else {
                    echo $this->debug === false ? "" : " - new store set\n";

                }
            }
            $store_set->updatePrice($json['price'], $debug = $this->debug !== false);

            $currentPrice = $store_set->getCurrentPrice();
            if (isset($json['in_stock']) && !$json['in_stock']) {
                echo $this->debug === false ? "" : " - setting status to out of stock\n";
                $currentPrice->status_id = StoreSetPrice::STATUS_OUT_OF_STOCK;
                $currentPrice->save();
            } elseif(isset($json['in_stock']) && $json['in_stock'] && $currentPrice->status_id == StoreSetPrice::STATUS_OUT_OF_STOCK) {
                echo $this->debug === false ? "" : " - setting status to available\n";
                $currentPrice->status_id = StoreSetPrice::STATUS_AVAILABLE;
                $currentPrice->save();
            }

        }

    }
}
