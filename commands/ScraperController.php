<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\LegoSet;
use app\models\Store;
use app\models\StoreSet;
use app\models\Theme;
use yii\console\Controller;

class ScraperController extends Controller
{

    public function actionOutput()
    {
        while (!feof(STDIN)){
            $content = fgets(STDIN, 1024);
            $json = json_decode($content, TRUE);
            if ($json) {
                try {
                    echo ".";
                    $this->processLine($json);
                } catch (\Exception $e) {
                    // do something with the exception ...
                }
            } else {
                echo "x";
            }

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
            $set = LegoSet::findSet($json['set_id']);
            if (!$set) {
                $set = new LegoSet();
                $set->title = substr($json['title'], 0, 100);
                $set->code = $json['set_id'];
                if (!$set->save()) {
                    // do something
                }
            }
            $store = Store::findStore($json['store']);
            if (!$store) {
                $store = new Store();
                $store->title = ucfirst($json['store']);
                $store->hash = $json['store'];
                $store->save();
            }
            $store_set = StoreSet::findSet($store, $set);
            if (!$store_set) {
                $store_set = new StoreSet();
                $store_set->store_id = $store->id;
                $store_set->legoset_id = $set->id;
                $store_set->url = $json['link'];
                if (!$store_set->save()) {
                    // do something
                }
            }
            $store_set->updatePrice($json['price']);

        }

    }
}
