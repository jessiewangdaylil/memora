<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Road;
use App\Models\TempAddress;
use App\Models\Town;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use League\Csv\CsvException;
use League\Csv\Reader;

class FetchAddrDataController extends Controller
{
//建立路徑
    public $folderPathString = 'app\public\csv';
    public $filename = 'data.csv'; //檔案名稱(包含附檔名)
    public $filenameN = 'data_new.csv'; //新檔案名稱(包含附檔名)
    public $url = 'https://data.moi.gov.tw/MoiOD/System/DownloadFile.aspx?DATA=AE071E62-42F3-4DE1-BA2A-03F2DBFB8713';

/**
 *
 * 取得地址的API方法
 * @return  執行後的狀態
 */
    public function getAddrApi()
    {
//處裡存放路徑
        //檔案位置的資料夾位置
        $folderPath = storage_path($this->folderPathString);
        //檔案路徑位置
        $filePath = storage_path($this->folderPathString . '\\' . $this->filename);
        //檔案路徑位置
        $filePathN = storage_path($this->folderPathString . '\\' . $this->filenameN);
//爬蟲:到網路上取得資料
        $response = Http::get($this->url);
        //檢查是否爬取成功
        if ($isSucces = $response->ok()) {
            //檢查檔案路徑資料夾是否存在
            if (!File::isDirectory($this->folderPathString)) {
                File::makeDirectory($folderPath, 0700, true, true);
            }
            //檢查檔案是否存在
            if (!File::exists($filePath)) {
                //不存在
                //將爬取的CSV存入指定檔案路徑
                file_put_contents($filePath, $response->body());
                // base File 當前檔案
                $csviteratorB = $this->readCSV($filePath);
                //iterator轉換成Array
                $data = iterator_to_array($csviteratorB);
                //存取至資料庫
                $isSave = $this->storeToTempAddr($data, $this->url, $filePath);
                //iterator轉換成Array
                $basicData = iterator_to_array($csviteratorB);
                //爬取資料分city、town、road項處裡->資料留存
                $addrData = $this->addrApiFilter($basicData);
                //新增city、town、road至資料表
                return $this->createAddrdatabase($addrData);
            } else {
                //將新爬取的檔案存入本機
                file_put_contents($filePathN, $response->body());
                // base File 當前檔案
                $csviteratorO = $this->readCSV($filePath);
                //new File 新爬取檔案
                $csviteratorN = $this->readCSV($filePathN);
                //iterator轉換成Array
                $oldData = iterator_to_array($csviteratorO);
                $newData = iterator_to_array($csviteratorN);
                //存取至資料庫
                // $isSave = $this->storeToTempAddr($newData, $this->url, $filePathN);
                // 比較 新爬取檔案 與 當前檔案是否有差異
                $diff = $this->compareStrArrDiff($newData, $oldData);
                $diffFromN = $diff[1];
                // dd($diffFromN);
                //爬取資料分city、town、road項處裡
                $addrDataO = $this->addrApiFilter($oldData);
                $addrDataN = $this->addrApiFilter($newData);
                array_unshift($diffFromN, $newData[0], $newData[1]); //配合addrApiFilter 的邏輯
                $addrDataD = $this->addrApiFilter($diffFromN);
                //新增city、town、road至資料表
                $status = $this->createAddrdatabase($addrDataD);
                //將新csv資料取代舊資料
                file_put_contents($filePath, $response->body());
                return $status;
            }
        } else {
            return '爬取失敗';
        }
    }
    /**
     *
     * 將 $this->addrApiFilter後的資料新增到city、town、road Table 中
     * @return ['執行後的狀態'=>'狀態名稱']
     */
    public function createAddrdatabase($addrData)
    {
        //分別取出city、town、road
        $city = $addrData[0];
        $town = $addrData[1]; //值的格式 縣市名稱+鄉政名稱
        $road = $addrData[2];

        //指定國家代碼條件為'TW' 台灣
        $country = Country::where('code', 'TW')->first();
        //存入城市資料庫
        $status = $this->storeCityTable($city, $country);
        if ($status['status'] = 'saveSuccess') {
            //存入鄉鎮區資料庫
            $status = $this->storeTownTable($town, $city, $country);
            if ($status['status'] = 'saveSuccess') {
                //存入道路資料庫
                $status = $this->storeRoadTable($road, $town, $city, $country);
                if ($status['status'] = 'saveSuccess') {
                    return ['已存入資料庫', $status];
                } else {
                    return ['道路資料存入資料表失敗，請手動更改', $status];
                }
            } else {
                return ['鄉鎮區資料存入資料表失敗，請手動更改', $status];
            }
        } else {
            return ['城市資料存入資料表失敗，請手動更改', $status];
        }
    }

    /**
     *
     * 存入資料到城市資料庫
     * @return ['給維護人員的資訊','執行後的狀態'=>'狀態名稱']
     */
    public function storeCityTable($city, $country)
    {
        //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱
        $i = 0;
        foreach ($city as $key) {
            try {
                if (count(City::where('name', $key[4])->where('level', $key[0])->where('country_id', $country->id)->get()) == 0) {
                    $addCity = new City;
                    $addCity->name = $key[4];
                    $addCity->level = $key[0];
                    $addCity->country_id = $country->id;
                    $addCity->save();
                    $i++;
                }
            } catch (Exception $e) {
                $k = $i;
                $i = 0;
                foreach ($city as $key) {
                    try {
                        $city = City::where('name', $key[4])->where('level', $key[0])->where('country_id', $country->id)->latest('created_at')->first();
                        $city->delete();
                        if ($i >= $k) {
                            break;
                        }
                        $i++;
                    } catch (Exception $e) {
                        return ['status' => 'deleteCitiesFailed', 'errorIndex' => $i];
                    }
                }
            }
        }
        return ['status' => 'saveSuccess', 'alreadySaveindex' => $i];
    }

    /**
     *
     * 存入資料到鄉鎮區資料庫
     * @return ['給維護人員的資訊','執行後的狀態'=>'狀態名稱']
     */
    public function storeTownTable($town, $city, $country)
    {
        //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱
        $i = 0;
        foreach ($town as $key) {
            try {
                $cityQuery[$i] = City::where('name', $city[$key[2]][4])->where('country_id', $country->id)->first();
                if (count(Town::where('name', substr($key[4], 3 * 3, 3 * 3))->where('level', $key[0])->where('city_id', $cityQuery[$i]->id)->get()) == 0) {
                    $addTown = new Town;
                    $addTown->name = substr($key[4], 3 * 3, 3 * 3);
                    $addTown->level = $key[0];
                    $addTown->city_id = $cityQuery[$i]->id;
                    $addTown->save();
                    $i++;
                }
            } catch (Exception $e) {
                $k = $i;
                $i = 0;
                foreach ($town as $key) {
                    try {
                        $towm = Town::where('name', substr($key[4], 3 * 3, 3 * 3))->where('level', $key[0])->where('city_id', $cityQuery[$i]->id)->latest('created_at')->first();
                        if (!$towm == null) {
                            $towm->delete();
                        }
                        if ($i >= $k) {
                            break;
                        }
                        $i++;

                    } catch (Exception $e) {
                        return ['status' => 'deleteTownsFailed', 'errorIndex' => $i];
                    }
                }
            }
        }
        return ['status' => 'saveSuccess', 'alreadySaveindex' => $i];
    }

    /**
     *
     *  存入資料到道路資料庫
     * @return ['給維護人員的資訊','執行後的狀態'=>'狀態名稱']
     */
    public function storeRoadTable($road, $town, $city, $country)
    {
        set_time_limit(1000);
//$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱
        $i = 0;
        foreach ($road as $key) {
            try {
                $cityQuery = City::where('name', $city[$town[$key[2]][2]][4])->where('country_id', $country->id)->first();
                $townQuery[$i] = Town::where('city_id', $cityQuery->id)->where('name', substr($town[$key[2]][4], 3 * 3, 3 * 3))->first();
                if (count(Road::where('name', $key[4])->where('level', $key[0])->where('town_id', $townQuery[$i]->id)->get()) == 0) {
                    $addRoad = new Road;
                    $addRoad->name = $key[4];
                    $addRoad->level = $key[0];
                    $addRoad->town_id = $townQuery[$i]->id;
                    $addRoad->save();
                    $i++;
                }
            } catch (Exception $e) {
                $k = $i;
                $i = 0;
                foreach ($road as $key) {
                    try {
                        $road = Road::where('name', $key[4])->where('level', $key[0])->where('town_id', $townQuery[$i]->id)->latest('created_at')->first();
                        if (!$road == null) {
                            $road->delete();
                        }
                        if ($i >= $k) {
                            break;
                        }
                        $i++;
                    } catch (Exception $e) {
                        return ['status' => 'deleteTownsFailed', 'errorIndex' => $i];
                    }
                }

            }
        }
        return ['status' => 'saveSuccess', 'alreadySaveindex' => $i];
    }

    /**
     *
     * 將讀取的csv檔資料轉為json格式存入資料庫
     * @return ['執行後的狀態'=>'狀態名稱']
     */
    public function storeToTempAddr($data, $url, $path)
    {
        try {
            $json = json_encode($data);
            //處裡存入資料路徑名稱
            $today = Carbon::now()->toDateTimeString();
            $today = str_replace(" ", "_", $today);
            $today = str_replace(":", "-", $today);
            $folderPathString = 'app\public\json\addr';
            //檔案位置的資料夾位置
            $folderPath = storage_path($folderPathString);
            //檢查存入路徑是否存在
            if (!File::isDirectory($this->folderPathString)) {
                File::makeDirectory($folderPath, 0700, true, true);
            }
            //檔案路徑位置
            $filePath = storage_path($folderPathString . '\\' . 'addr_' . $today . '.json');
            //將json檔存入至指定路徑
            file_put_contents($filePath, $json);
            //將暫存資料資訊存入資料庫
            $tempAddr = new TempAddress;
            $tempAddr->json_F_Path = $filePath;
            $tempAddr->url = $url;
            $tempAddr->path = $path;
            $tempAddr->save();
            return ['status' => 'success'];
        } catch (Exception $e) {
            return ['status' => 'failed', $e];
        }
    }

    /**
     *
     * 提供路徑讀取存在的csv檔
     * @return [城市資料,鄉政資料,路名資料]
     */
    public function readCSV($filePath)
    {
        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $records = $csv->getRecords();

        } catch (CsvException $e) {
            $records = [];
        } catch (Exception $e) {
            $records = [];
        }
        return $records;
    }

    /**
     *
     * 解析陣列版本的地址資料
     * @return [城市資料,鄉政資料,路名資料]
     */
    public function addrApiFilter($array2D_col3)
    {
        $i = 0;
        $cityDatas = [];
        $townDatas = [];
        $roadDatas = [];
        $createIndex = [0, 0, 0];
        $temp = [];

        foreach ($array2D_col3 as $key) {
            if ($i > 2) {
                if ($key[0] == $temp[0]) {
                    //city與前一個相同  #流程2
                    if ($key[1] == $temp[1]) {
                        //city與Town前一個相同
                        //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱//pushIndex 1 city 2 town 3 road  (country 0)
                        $father = $townDatas[$createIndex[1] - 1][1];
                        array_push($roadDatas, [3, $createIndex[2]++, $father, null, $key[2]]);
                        array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]);
                        // dd($cityDatas, $townDatas, $roadDatas);

                    } else {
                        //city與前一個相同、Town與前一個不相同 #流程3
                        //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱//pushIndex 1 city 2 town 3 road  (country 0)
                        $father = $cityDatas[$createIndex[0] - 1][1];
                        array_push($townDatas, [2, $createIndex[1]++, $father, array(), $key[1]]);
                        $father = $townDatas[$createIndex[1] - 1][1];
                        array_push($roadDatas, [3, $createIndex[2]++, $father, null, $key[2]]);
                        array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]);
                        array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]);
                        // dd($cityDatas, $townDatas, $roadDatas);

                    }
                } else {
                    //city、Town與前一個不相同 #流程4
                    //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱//pushIndex 1 city 2 town 3 road  (country 0)
                    array_push($cityDatas, [1, $createIndex[0]++, null, array(), $key[0]]);
                    array_push($townDatas, [2, $createIndex[1]++, null, array(), $key[1]]);
                    array_push($roadDatas, [3, $createIndex[2]++, null, null, $key[2]]);
                    array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]); //city 子階層關聯
                    $townDatas[$createIndex[1] - 1][2] = $cityDatas[$createIndex[0] - 1][1]; //town 父階層關聯
                    array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]); //town 子階層關聯
                    $roadDatas[$createIndex[2] - 1][2] = $townDatas[$createIndex[1] - 1][1]; //road 父階層關聯
                    // dd($cityDatas, $townDatas, $roadDatas);
                }
            } elseif ($i == 2) {
                //第一筆   #流程1
                //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱
                //pushIndex 1 city 2 town 3 road  (country 0)
                array_push($cityDatas, [1, $createIndex[0]++, null, array(), $key[0]]);
                array_push($townDatas, [2, $createIndex[1]++, null, array(), $key[1]]);
                array_push($roadDatas, [3, $createIndex[2]++, null, null, $key[2]]);

                array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]); //city 子階層關聯
                $townDatas[$createIndex[1] - 1][2] = $cityDatas[$createIndex[0] - 1][1]; //town 父階層關聯
                array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]); //town 子階層關聯
                $roadDatas[$createIndex[2] - 1][2] = $townDatas[$createIndex[1] - 1][1]; //road 父階層關聯
                // dd($cityDatas, $townDatas, $roadDatas);
            }
            $temp = $key;
            $i++;
        }
        return [$cityDatas, $townDatas, $roadDatas];
    }

/**
 *
 * 比較兩個csv轉換的陣列資料是否相同
 * @return 差異的資料 [(array)城市資料,(array)鄉政資料,(array)路名資料]
 */
    public function compareStrArrDiff($arr, $arr2)
    {
        // $key為csv型式的字串，join()將轉換陣列資料
        $i = 0;
        foreach ($arr as $key) {
            $strdata[$i++] = join(', ', $key);
        }
        $i = 0;
        foreach ($arr2 as $key2) {
            $strdata2[$i++] = join(', ', $key2);
        }
        //比較兩者陣列差異
        $diffStr = array_diff($strdata, $strdata2);
        $newDataFromArr = []; //最新資料增加內容
        $deleteDataFromArr2 = []; //舊資料多餘內容(淘汰)
        $i = 0;
        foreach ($diffStr as $row) {
            for ($j = 0; $j < count($arr); $j++) {
                if (join(', ', $arr[$j]) == $row) {
                    array_push($newDataFromArr, $arr[$j]);
                    break;
                }
            }
        }
        $i = 0;
        foreach ($diffStr as $row) {
            for ($j = 0; $j < count($arr2); $j++) {
                if (join(', ', $arr2[$j]) == $row) {
                    array_push($deleteDataFromArr2, $arr[$j]);
                    break;
                }
            }
        }
        return [$diffStr, $newDataFromArr, $deleteDataFromArr2];
    }
}