<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FetchCountryPhoneDataController extends Controller
{
    public $url = 'https://gist.github.com/jnlin/0847cd6f5db2fe510270/archive/feba481ddea22c0e55e490d5a7bffa8e2ea49d0d.zip'; //爬取zip檔網址
    public $zipExtractFolder = '0847cd6f5db2fe510270-feba481ddea22c0e55e490d5a7bffa8e2ea49d0d'; //解壓縮後的zip檔資料夾
    public $zipFolderPath = 'app/public/zip/cityphone'; //zip檔存取資料夾路徑
    public $zipPath = '/public/zip/cityphone/country.zip'; //zip檔所在路徑
    public $extractPath = 'app/public/json/cityphone'; //解壓縮資料存放位置
    public $extractFolderPrefix = 'countryphone';
    public function getCountryPhoneCodeApi()
    {
        //爬取資料
        $client = new Client();
        $response = $client->get($this->url);
        //確認是否爬取成功
        $withOldFile = false;
        if ($response->getReasonPhrase() == 'OK') {
            $data = $response->getBody()->getContents();
            $time = Carbon::now()->toDateTimeString();
            clearstatcache();

            if (!File::exists($this->zipFolderPath)) {
                File::makeDirectory($this->zipFolderPath, 0700, true, true);}

            if (!File::exists($this->extractPath)) {
                File::makeDirectory($this->extractPath, 0700, true, true);
            } else {
                Storage::put($this->zipPath, $response->getBody());
                $zip = new ZipArchive;
                $zip->open(storage_path('app/' . $this->zipPath));
                $createExtractFolder = $this->extractPath . '/' . $time;
                $createExtractFolder = str_replace(" ", "_", $createExtractFolder);
                $createExtractFolder = str_replace(":", "-", $createExtractFolder);
                File::makeDirectory($createExtractFolder, 0700, true, true);
                //檢查json/cityphone 是否已有舊資料
                $files = File::directories($this->extractPath);
                $olderFolder = '';
                dd($files);
                foreach ($files as $file) {
                    dd(basename($file));
                    if (strpos(basename($file), $this->extractFolderPrefix) > -1) {
                        $withOldFile = true;
                        $olderFolder = basename($file);
                        break;
                    }
                }
                $zip->extractTo(storage_path($createExtractFolder));
                $zip->close();
                if (!$withOldFile) {
                    $dataPath = $createExtractFolder . '/' . $this->zipExtractFolder . '/country.json';
                    $data = file_get_contents(storage_path($dataPath));
                    $jsonData = json_decode($data, true);
                    dd($jsonData);

                } else {
                    $dataPathN = $createExtractFolder . '/' . $this->zipExtractFolder . '/country.json';
                    $dataPathO = $this->extractPath . '/' . $olderFolder . '/' . $this->zipExtractFolder . '/country.json';
                    $dataN = file_get_contents(storage_path($dataPathN));
                    $jsonDataN = json_decode($dataN, true);
                    $dataO = file_get_contents(storage_path($dataPathO));
                    $jsonDataO = json_decode($dataO, true);
                    dd($jsonDataN, $jsonDataO);

                }

            }

        } else {
            return '爬取失敗';
        }

// dd(storage_path('app\public\zip\cityphone\country.zip'));

        // //建立國家代碼表
        // $userinfo_country_code = $jsonData['userinfo_country_code'];
        // $i = 0;
        // $country_code = [];
        // foreach ($userinfo_country_code as $key => $value) {
        //     if ($i > 0) {
        //         $country_code[$key] = substr($value, 0, strpos($value, '(') - 1);
        //     }

        //     $i++;
        // }
        // //國家代碼與國家名稱+電話碼
        // $userinfo_country_code['userinfo_country_code'];
        // //國家代碼與電話碼
        // $userinfo_country_code['id_to_countrycode'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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