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
    public function index()
    {

        $response = Http::get('https://data.moi.gov.tw/MoiOD/System/DownloadFile.aspx?DATA=AE071E62-42F3-4DE1-BA2A-03F2DBFB8713'); //爬蟲:到網路上取得資料
        $filename = 'data.csv'; //檔案名稱(包含附檔名)
        $filePath = storage_path('app\public\csv\\' . $filename); //檔案路徑位置
        $folderPath = storage_path('app\public\csv'); //檔案位置的資料夾位置
        //檢查檔案位置的資料夾是否存在
        if (!File::isDirectory('app\public\csv')) {
            File::makeDirectory($folderPath, 0700, true, true);
        }
        file_put_contents($filePath, $response->body()); //不管檔案是否已存在將爬蟲資料存入指定路徑檔案中，如果不存在自動生成

        // 指定下載的檔案名稱

        // dd($townRelaCity);

// // 比較 新爬取檔案 與 當前檔案是否有差異
// // base File 當前檔案
//         $baseFPath = storage_path('app\public\csv\data.csv');
//         $csvB = Reader::createFromPath($baseFPath, 'r');
//         $recordsB = $csvB->getRecords();
// //new File 新爬取檔案
//         $newFPath = storage_path('app\public\csv\ndata.csv');
//         $csvN = Reader::createFromPath($newFPath, 'r');
//         $recordsN = $csvN->getRecords();
// // 比較
//         if ($recordsB == $recordsN) {
//             dd("兩個 CSV 檔案的內容完全相同");
//         } else {
//             dd("兩個 CSV 檔案的內容不相同");
//         }

//         $response = Http::get('https://data.moi.gov.tw/MoiOD/System/DownloadFile.aspx?DATA=AE071E62-42F3-4DE1-BA2A-03F2DBFB8713');
//         file_put_contents($filePath, $response->body());
//         $data = $response->body();
//         $isSucces = $response->redirect();
//         $dataObj = $response->body();

//         //
//         $filename = 'data.csv'; // 指定下載的檔案名稱
//         $filePath = storage_path("app\public\csv\\" . $filename);
//         $rows = array_map('str_getcsv', file($filePath));
//         $i = 0;
//         foreach ($rows as $row) {
//             $city[$i] = $row[0];
//             $town[$i] = $row[1];
//             $road[$i] = $row[2];

//             if ($i > 1) {
//                 $townTrim[$i] = substr($row[1], 3 * 3, strlen($row[1]) - (3 * 3)); // dd(strlen($row[1]));
//             } else {
//                 $townTrim[$i] = $row[1];
//             }
//             $i++;
//         }
//         $cityuni = array_unique($city); //ok
//         $townuni = array_unique($town); //ok

//         $i = 2;
//         $j = 2;
//         $towndata[0] = $town[0];
//         $towndata[1] = $town[1];
//         $towndataTrim[0] = $roadRelaTown[0] = 'roadId_townId';
//         $towndataTrim[1] = $roadRelaTown[1] = '道路所屬的鄉鎮';
//         foreach (array_slice($townuni, 2) as $key => $value) {
//             $towndata[$i] = $value;
//             $towndataTrim[$i] = substr($value, 3 * 3, strlen($value) - 3 * 3);

//             for ($k = $j; $k < count($town); $k++) {
//                 if ($value == $town[$k]) {
//                     $roadRelaTown[$k] = $i;
//                 } else {
//                     $j = $k;
//                     $k = count($town);
//                 }
//             }
//             $i++;
//         }

//         $i = 0;
//         $j = 2;
//         $townRelaCity[0] = 'cityId_townId';
//         $townRelaCity[1] = '鄉鎮附屬於的城市';
//         foreach (array_slice($cityuni, 2) as $key => $value) {
//             $citydata[$i] = $value;
//             for ($k = $j; $k < count($towndata); $k++) {
//                 // dd($towndata);

//                 if ($value == substr($towndata[$k], 0, 3 * 3)) {
//                     $townRelaCity[$k] = $i;
//                 } else {
//                     $j = $k;
//                     $k = count($towndata);
//                 }
//             }

//             $i++;
//         }

        // dd($townRelaCity);

        // return view('read_user');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
