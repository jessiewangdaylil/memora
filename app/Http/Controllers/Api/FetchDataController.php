<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TempAddress;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use League\Csv\CsvException;
use League\Csv\Reader;
use ZipArchive;

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
    public $url = 'https://data.moi.gov.tw/MoiOD/System/DownloadFile.aspx?DATA=AE071E62-42F3-4DE1-BA2A-03F2DBFB8713';
    public function getApi()
    {
//處裡存放路徑
        $folderPath = storage_path($this->folderPathString); //檔案位置的資料夾位置
        $filePath = storage_path($this->folderPathString . '\\' . $this->filename); //檔案路徑位置
        $filePathN = storage_path($this->folderPathString . '\\' . $this->filenameN); //檔案路徑位置

/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

//爬蟲:到網路上取得資料
        $response = Http::get($this->url);
        if ($isSucces = $response->ok()) {
            //檢查檔案位置的資料夾是否存在
            if (!File::exists($filePath)) {
                //不存在
                if (!File::isDirectory($this->folderPathString)) {
                    File::makeDirectory($folderPath, 0700, true, true);
                    file_put_contents($filePath, $response->body());
                    //不管檔案是否已存在將爬蟲資料存入指定路徑檔案中，如果不存在自動生成
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
                    $this->createAddrdatabase($addrData);

                }

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
                // $this->createAddrdatabase($addrDataD);
                $this->getCityAddrApi();
                dd($addrDataD);
                // return $isSave;
                //沒爬成功要做的通知
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
        $city = $addrData[0];
        // dd($city);
        $town = $addrData[1];
        $road = $addrData[2];
        $i = 0;
        foreach ($city as $key) {
            // try {
            $addCity = new City;
            $addCity->name = $key[4];
            // $addCity->level = $key[0];
            // $addCity->country_id = ;
            $addCity->save();
            $i++;
            // } catch (Exception $e) {
            //     dd('failed');
            //     return ['saveLavel' => '1', 'status' => 'saveFailed', 'FailedFrom' => $i, 'errorInfo' => $e];
            // }

        }

        return ['status' => 'success'];
    }
    public function getCityAddrApi()
    {
        $client = new Client();

        $response = $client->get('https://gist.github.com/jnlin/0847cd6f5db2fe510270/archive/feba481ddea22c0e55e490d5a7bffa8e2ea49d0d.zip');
        $zipFolder = '0847cd6f5db2fe510270-feba481ddea22c0e55e490d5a7bffa8e2ea49d0d';

        $data = $response->getBody()->getContents();
        $zipPath = '/public/zip/addr/country.zip';
// dd(storage_path('app\public\zip\addr\country.zip'));
        Storage::put($zipPath, $response->getBody());
        $extractPath = 'app/public/json/addr';

        $zip = new ZipArchive;
        $zip->open(storage_path('app\\' . $zipPath));
        $zip->extractTo(storage_path($extractPath));
        $zip->close();
        $dataPath = $extractPath . '/' . $zipFolder . '/country.json';
        $data = file_get_contents(storage_path($dataPath));
        $jsonData = json_decode($data, true);
        dd($jsonData);
        //建立國家代碼表
        $userinfo_country_code = $jsonData['userinfo_country_code'];
        $i = 0;
        $country_code = [];
        foreach ($userinfo_country_code as $key => $value) {
            if ($i > 0) {
                $country_code[$key] = substr($value, 0, strpos($value, '(') - 1);
            }

            $i++;
        }
        //國家代碼與國家名稱+電話碼
        $userinfo_country_code['userinfo_country_code'];
        //國家代碼與電話碼
        $userinfo_country_code['id_to_countrycode'];

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
            $today = Carbon::now()->toDateTimeString();
            $today = str_replace(" ", "_", $today);
            $today = str_replace(":", "-", $today);
            $folderPathString = 'app\public\json\addr';
            $folderPath = storage_path($folderPathString); //檔案位置的資料夾位置
            if (!File::isDirectory($this->folderPathString)) {
                File::makeDirectory($folderPath, 0700, true, true);
            }
            $filePath = storage_path($folderPathString . '\\' . 'addr_' . $today . '.json'); //檔案路徑位置
            file_put_contents($filePath, $json);
            $tempAddr = new TempAddress;
            $tempAddr->json_F_Path = $filePath;
            $tempAddr->url = $url;
            $tempAddr->path = $path;
            $tempAddr->save();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return $e;
            return ['status' => 'failed'];
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
                        array_push($roadDatas, [2, $createIndex[2]++, $father, null, $key[2]]);
                        array_push($townDatas[$createIndex[1] - 1][3], $roadDatas[$createIndex[2] - 1][1]);
                        // dd($cityDatas, $townDatas, $roadDatas);

                    } else {
                        //city與前一個相同、Town與前一個不相同 #流程3
                        //$datas 0階層 1編號 2 父關聯  3子關聯 4 名稱//pushIndex 1 city 2 town 3 road  (country 0)
                        $father = $cityDatas[$createIndex[0] - 1][1];
                        array_push($townDatas, [1, $createIndex[1]++, $father, array(), $key[1]]);
                        $father = $townDatas[$createIndex[1] - 1][1];
                        array_push($roadDatas, [2, $createIndex[2]++, $father, null, $key[2]]);
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
            $temp = $key;
            $i++;
        }
        return [$cityDatas, $townDatas, $roadDatas];
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
        $diffStr = array_diff($strdata, $strdata2);
        $newDataFromArr = [];
        $deleteDataFromArr2 = [];
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

}