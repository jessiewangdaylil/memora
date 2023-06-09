<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class FetchDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//建立路徑
    public $folderPathString = 'app\public\csv';
    public $filename = 'data.csv'; //檔案名稱(包含附檔名)
    public $filenameN = 'data_new.csv'; //新檔案名稱(包含附檔名)
    public function getApi()
    {
        $folderPath = storage_path($this->folderPathString); //檔案位置的資料夾位置
        $filePath = storage_path($this->folderPathString . '\\' . $this->filename); //檔案路徑位置
        $filePathN = storage_path($this->folderPathString . '\\' . $this->filenameN); //檔案路徑位置

//----------------------------------------------------------------------------
        //爬蟲:到網路上取得資料 {
        // $response = Http::get('https://data.moi.gov.tw/MoiOD/System/DownloadFile.aspx?DATA=AE071E62-42F3-4DE1-BA2A-03F2DBFB8713');
        // if ($isSucces = $response->ok()) {
        //     if (!File::exists($filePath)) {
        //         //檢查檔案位置的資料夾是否存在
        //         if (!File::isDirectory($this->folderPathString)) {
        //             File::makeDirectory($folderPath, 0700, true, true);
        //         }
        //         file_put_contents($filePath, $response->body()); //不管檔案是否已存在將爬蟲資料存入指定路徑檔案中，如果不存在自動生成
        //     } else {
        //         file_put_contents($filePathN, $response->body());

        //         // 比較 新爬取檔案 與 當前檔案是否有差異
        //         // base File 當前檔案
        //         $csvO = Reader::createFromPath($filePath, 'r');
        //         $recordsO = $csvO->getRecords();
        //         //new File 新爬取檔案
        //         $csvN = Reader::createFromPath($filePathN, 'r');
        //         $recordsN = $csvN->getRecords();
        //         //iterator轉換成Array
        //         $newData = iterator_to_array($recordsN);
        //         $old = iterator_to_array($recordsO);

        //         $diff = $this->compareStrArrDiff($newData, $old);
        //         $i = 0;
        //         $cityDatas = [];
        //         $townDatas = [];
        //         $roadDatas = [];
        //         $createIndex = [0, 0, 0];
        //         $temp = [];

        //         //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱
        //         //pushIndex 0 city 1 town 2 road
        //         foreach ($newData as $keyN) {
        //             if ($i > 2) {
        //                 if ($keyN[0] == $temp[0]) {
        //                     //city與前一個相同
        //                     if ($keyN[1] == $temp[1]) {
        //                         //city與Town前一個相同
        //                         $father = $townDatas[$createIndex[1] - 1][1];
        //                         array_push($roadDatas, [2, $createIndex[2]++, $father, null, $keyN[2]]);
        //                         array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]);
        //                         // dd($cityDatas, $townDatas, $roadDatas);

        //                     } else {
        //                         //city與前一個相同、Town與前一個不相同
        //                         $father = $cityDatas[$createIndex[0] - 1][1];
        //                         array_push($townDatas, [1, $createIndex[1]++, $father, array(), $keyN[1]]);
        //                         $father = $townDatas[$createIndex[1] - 1][1];
        //                         array_push($roadDatas, [2, $createIndex[2]++, $father, null, $keyN[2]]);
        //                         array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]);
        //                         array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]);
        //                     }
        //                 } else {
        //                     //city、Town與前一個不相同
        //                     array_push($cityDatas, [0, $createIndex[0]++, null, array(), $keyN[0]]);
        //                     array_push($townDatas, [1, $createIndex[1]++, null, array(), $keyN[1]]);
        //                     array_push($roadDatas, [2, $createIndex[2]++, null, null, $keyN[2]]);
        //                     array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]); //city 子階層關聯
        //                     $townDatas[$createIndex[1] - 1][2] = $cityDatas[$createIndex[0] - 1][1]; //town 父階層關聯
        //                     array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]); //town 子階層關聯
        //                     $roadDatas[$createIndex[2] - 1][2] = $townDatas[$createIndex[1] - 1][1]; //road 父階層關聯

        //                 }
        //             } elseif ($i == 2) {
        //                 //第一筆
        //                 array_push($cityDatas, [0, $createIndex[0]++, null, array(), $keyN[0]]);
        //                 array_push($townDatas, [1, $createIndex[1]++, null, array(), $keyN[1]]);
        //                 array_push($roadDatas, [2, $createIndex[2]++, null, null, $keyN[2]]);

        //                 array_push($cityDatas[$createIndex[0] - 1][3], $townDatas[$createIndex[1] - 1][1]); //city 子階層關聯
        //                 $townDatas[$createIndex[1] - 1][2] = $cityDatas[$createIndex[0] - 1][1]; //town 父階層關聯
        //                 array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]); //town 子階層關聯
        //                 $roadDatas[$createIndex[2] - 1][2] = $townDatas[$createIndex[1] - 1][1]; //road 父階層關聯

        //             }
        //             $temp = $keyN;
        //             $i++;
        //         }
        //         // dd($cityDatas, $townDatas, $roadDatas);
        //         // dd(json_encode($cityDatas));
        //         dd(json_decode(json_encode($cityDatas)));

        //     }
        // } else {
        //     dd('沒有導向');
        //     //沒爬成功要做的通知

        // }

        // return view('read_user');

    }

    public function compareStrArrDiff($arr, $arr2)
    {
        $i = 0;
        foreach ($arr as $key) {
            $strdata[$i++] = join(', ', $key);
        }
        $i = 0;
        foreach ($arr2 as $key2) {
            $strdata2[$i++] = join(', ', $key2);
        }
        $diff = array_diff($strdata, $strdata2);
        return $diff;
    }
    public function cityTownFilter($new, $old)
    {
        $i = 0;
        $O = [];
        $N = [];
        $temp = [];
        $tempCity = [];
        $tempTown = [];

        foreach ($new as $keyN) {
            if ($i > 2 && $i < count($new) - 1) {
                if ($keyN[0] == $temp[0]) {
                    //city與前一個相同
                    if ($keyN[1] == $temp[1]) {
                        //city與Town與前一個相同
                        array_push($tempTown, $keyN);

                    } else {
                        //city與前一個相同、Town與前一個不相同
                        array_push($tempCity, $tempTown);
                        $tempTown = [];
                        array_push($tempTown, $keyN);
                    }
                } else {
                    //cityTown與前一個與前一個不相同
                    array_push($tempCity, $tempTown);
                    // dd($tempCity);
                    $tempTown = [];
                    // $N = $tempCity;
                    array_push($N, $tempCity);
                    // dd($N);
                    $tempCity = [];
                    array_push($tempTown, $keyN);
                }
            } elseif ($i == 2) {
                array_push($tempTown, $keyN); //第一筆
            } elseif ($i == count($new) - 1) {
                array_push($tempTown, $keyN);
                array_push($tempCity, $tempTown);
                array_push($N, $tempCity);
            }
            $temp = $keyN;
            $i++;
        }
        $i = 0;
        $temp = [];
        $tempCity = [];
        $tempTown = [];
        foreach ($old as $keyO) {
            if ($i > 2 && $i < count($old) - 1) {
                if ($keyO[0] == $temp[0]) {
                    //city與前一個相同
                    if ($keyO[1] == $temp[1]) {
                        //city與Town與前一個相同
                        array_push($tempTown, $keyO);

                    } else {
                        //city與前一個相同、Town與前一個不相同
                        array_push($tempCity, $tempTown);
                        $tempTown = [];
                        array_push($tempTown, $keyO);
                    }
                } else {
                    //cityTown與前一個與前一個不相同
                    array_push($tempCity, $tempTown);
                    // dd($tempCity);
                    $tempTown = [];
                    // $N = $tempCity;
                    array_push($O, $tempCity);
                    // dd($N);
                    $tempCity = [];
                    array_push($tempTown, $keyO);
                }
            } elseif ($i == 2) {
                array_push($tempTown, $keyO); //第一筆
            } elseif ($i == count($old) - 1) {
                array_push($tempTown, $keyO);
                array_push($tempCity, $tempTown);
                array_push($O, $tempCity);
            }
            $temp = $keyO;
            $i++;
        }

    }

/**
 * Store a newly created resource in storage.
 *
 * @param
 * @return
 */
    public function store($isInit)
    {
        if ($isInit == 'true') {
            $filePath = storage_path($this->folderPathString . '\\' . $this->filename); //舊檔案路徑位置
        } else {
            $filePath = storage_path($this->folderPathString . '\\' . $this->filenameN); //新檔案路徑位置
        }
        $content = $this->apiFilter($filePath);
        dd($content);
    }

/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show($id)
    {
        //
    }

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {
        //
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {
        //
    }
    public function readJsonFile(string $path, bool $isFlip = false)
    {

        $jsonFile = public_path($path);

        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            if ($isFlip == true) {
                $data = json_decode($jsonData, true);

                $swappJsonData = collect($data)->flip()->all();
                return $swappJsonData;
            } else {
                $data = json_decode($jsonData, true);
                return $data;
            }
        } else {
            return '';
        }
    }
// 'https: //od.moi.gov.tw/api/v1/rest/datastore/301000000A-000917-035'

    public function getWebJson(string $url)
    {
        $response = Http::get($url);
        $data = $response->json(); //json->array

        // 將回應儲存為檔案
        // file_put_contents($path, $response->body());
        return $data;
    }

    public function jsonFilter($arr, string $key)
    {
        $data = $arr[$key];

        return $data;
    }
    public function apiFilter($filePath)
    {
        //取得csv原始資料
        $rows = array_map('str_getcsv', file($filePath)); //原始csv資料
//建立city、town、road 的 初始化處裡容器
        $i = 0;
        foreach ($rows as $row) {
            $city[$i] = $row[0]; //只有city欄位名稱
            $town[$i] = $row[1]; //只有town欄位名稱
            $road[$i] = $row[2]; //只有road欄位名稱

            if ($i > 1) {
                $townTrim[$i] = substr($row[1], 3 * 3, strlen($row[1]) - (3 * 3)); // dd(strlen($row[1]));
                $road[$i] = $row[2]; //路名
            } else {
                $townTrim[$i] = $row[1]; //重複鄉政區
            }
            $i++;
        }
// dd($road);
//過濾city、town重複值
        $cityuni = array_unique($city); //不重複城市名稱(尚未修改鍵key)
        $townuni = array_unique($town); //不重複城市+鄉政區名稱(尚未修改鍵key)
//town、road修改鍵key名稱 的 初始化處裡容器
//處裡town+roadRelaTown
        $i = 2;
        $j = 2;
        $towndata[0] = $town[0];
        $towndata[1] = $town[1];
        $towndataTrim[0] = $roadRelaTown[0] = 'roadId_townId';
        $towndataTrim[1] = $roadRelaTown[1] = '道路所屬的鄉鎮';
        foreach (array_slice($townuni, 2) as $key => $value) {
            $towndata[$i] = $value; //不重複縣市+鄉政區名稱(修改鍵key)
            $towndataTrim[$i] = substr($value, 3 * 3, strlen($value) - 3 * 3); //不重複鄉政區名稱(修改鍵key)

            for ($k = $j; $k < count($town); $k++) {
                if ($value == $town[$k]) {
                    $roadRelaTown[$k] = $i;
                } else {
                    $j = $k;
                    $k = count($town);
                }
            }
            $i++;
        }
//處裡townRelaCity
        $i = 0;
        $j = 2;
        $townRelaCity[0] = 'cityId_townId';
        $townRelaCity[1] = '鄉鎮附屬於的城市';
        foreach (array_slice($cityuni, 2) as $key => $value) {
            $citydata[$i] = $value;
            for ($k = $j; $k < count($towndata); $k++) {

                if ($value == substr($towndata[$k], 0, 3 * 3)) {
                    $townRelaCity[$k] = $i;
                } else {
                    $j = $k;
                    $k = count($towndata);
                }
            }

            $i++;
        }
/*
-------------------------------------------------
$roadRelaTown | total | $townRelaCity |
-------------------------------------------------
$road         | 34694 | $towndataTrim | 361     |
$towndataTrim | 361   | $citydata     | 20      |
-------------------------------------------------
 */
        return ['city' => $citydata, 'town' => $towndataTrim, 'road' => $road, 'roadRelaTown' => $roadRelaTown, 'townRelaCity' => $townRelaCity];
    }

}