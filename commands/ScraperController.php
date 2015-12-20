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
use Yii;
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
        $exceptionCount = 0;
        while (!feof(STDIN)){
            $content = fgets(STDIN, 1024);
            $raw_input .= $content;
            $json = json_decode($content, TRUE);
            if ($json && isset($json['set_id'])) {
                try {
                    $this->processLine($json);
                } catch (\Exception $e) {
                    // do something with the exception ...
                    $exceptionCount ++;
                    $mail = Yii::$app->mailer->compose()
                        ->setTextBody($e)
                        ->setHtmlBody(nl2br("JSON: \n".print_r($json, true)."\n\n\n".$e))
                        ->setFrom(Yii::$app->params['fromEmail'])
                        ->setTo('bruce@incode.co.nz')
                        ->setSubject('Exception with scraper');
                    $mail->send();

                    if ($exceptionCount > 5) {
                        return;
                    }
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
        $this->checkStoreUpdates();
        $startYear = 2005; // go back a wee way
        $endYear = date('Y') + 1;

        for($i = $startYear; $i <= $endYear; $i ++) {
            $url = 'http://brickset.com/api/v2.asmx/getSets?apiKey=tizB-rqbL-rIXo&userHash=&query=&theme=&subtheme=&setNumber=&year='.$i.'&owned=&wanted=&orderBy=&pageSize=1000&pageNumber=1&userName=';
            $data = file_get_contents($url);
            file_put_contents('brickset_'.$i.'.xml', $data);
            $this->parseXML($data);
        }
        //$data = file_get_contents(__DIR__.'/test.xml');

        $cmd = Yii::$app->db->createCommand("UPDATE lego_set ls INNER JOIN (select max(price) p, code from lego_set ls
INNER JOIN store_set ss ON ls.id=ss.legoset_id
INNER JOIN store_set_price ssp on ss.id=ssp.store_set_id
WHERE ss.store_id!=10
GROUP BY code
HAVING count(price) > 1) x ON ls.code=x.code
SET rrp=x.p WHERE rrp is null;");
        $cmd->execute();

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

    private function checkStoreUpdates()
    {
        $sql = "SELECT title, unix_timestamp() - unix_timestamp(updated_at) last_update
                FROM (
                  SELECT s.title, ssp.updated_at
                  FROM store_set_price ssp
                  INNER JOIN store_set ss ON ss.id=ssp.store_set_id
                  INNER JOIN store s ON s.id=ss.store_id
                  ORDER BY ssp.updated_at DESC
                ) x GROUP BY title";
        $cmd = Yii::$app->db->createCommand($sql);

        $results = $cmd->queryAll();
        $outdated = [];
        foreach($results as $row) {
            if ((int) $row['last_update'] > 86400) {
                $outdated[] = $row['title'];
            }
        }
        if (count($outdated)) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['fromEmail'])
                ->setTo('bruce.aldridge@gmail.com')
                ->setSubject('Lego Prices DB: Stores outdated')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>scrapers need to be updated?</b><p>'.implode(', ', $outdated).'</p>')
                ->send();
        }

        // remove links last found more than 48hours ago
        $sql = "UPDATE store_set_price SET status_id=:expired WHERE status_id!=:expired && updated_at<=NOW() - INTERVAL 48 HOUR";

        Yii::$app->db->createCommand($sql, [':expired' => StoreSetPrice::STATUS_EXPIRED])->execute();
    }
}
