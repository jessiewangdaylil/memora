<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\PhoneCode;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
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

    /**
     * 爬蟲Api-國家電話碼、國家代碼
     *
     * @return $apiStstus 執行後的狀態
     */
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
            Artisan::call('clear-compiled'); //目前無效果
            //如果所需路徑不存在，新增相關路徑
            if (!File::exists($this->zipFolderPath)) {
                File::makeDirectory($this->zipFolderPath, 0700, true, true);
            }
            if (!File::exists($this->extractPath)) {
                File::makeDirectory($this->extractPath, 0700, true, true);
            }
            //將zip存入zip資料夾
            Storage::put($this->zipPath, $response->getBody());
            //開啟zip檔->
            $zip = new ZipArchive;
            $zip->open(storage_path('app/' . $this->zipPath));
            //建立解壓縮資料夾
            $createExtractFolder = $this->extractPath . '/' . $time;
            $createExtractFolder = str_replace(" ", "_", $createExtractFolder);
            $createExtractFolder = str_replace(":", "-", $createExtractFolder);
            //解壓縮
            File::makeDirectory($createExtractFolder, 0700, true, true);
            $zip->extractTo(storage_path($createExtractFolder));
            $zip->close();
            //檢查json/cityphone 是否已有舊資料
            $files = File::directories($this->extractPath);
            for ($j = count($files) - 2; $j >= 0; $j--) {
                try {
                    $dataPathO = '/' . $files[$j] . '/' . $this->zipExtractFolder . '/country.json';
                    $dataO = file_get_contents(storage_path($dataPathO));
                    $arrDataO = json_decode($dataO, true);
                    $withOldFile = true;
                    break;
                } catch (Exception $e) {
                    continue;
                }
            }
            //如果沒有存在舊資料，直接讀取，如果有，需另外再將舊檔開啟
            //沒有舊資料
            if (!$withOldFile) {
                //取得解壓縮的json資料
                $dataPath = $createExtractFolder . '/' . $this->zipExtractFolder . '/country.json';
                $data = file_get_contents(storage_path($dataPath));
                $arrData = json_decode($data, true);
                //處理資料並存入資料庫
                return $this->storeToTable($arrData);
                //有舊資料
            } else {
                //取得解壓縮的json資料-新資料
                $dataPathN = $createExtractFolder . '/' . $this->zipExtractFolder . '/country.json';
                $dataN = file_get_contents(storage_path($dataPathN));
                $arrDataN = json_decode($dataN, true);
                //確認新檔案(當前)與最近更新的舊檔案是否有差異，如果有，新增至資料庫
                $diff_2row = $this->compareStrArrDiff($arrDataN, $arrDataO);
                //檢測是否有新增的資料
                if ($diff_2row[0][0] == true || $diff_2row[0][1] == true) {
                    //處理資料並存入資料庫
                    $status = $this->storeToTable($diff_2row[1]);

                    if ($status[1]['status'] == 'saveSuccess') {
                        if ($diff_2row[0][2] == true || $diff_2row[0][3] == true) {
                            // 刪除舊資料
                            return $this->destoryToTable($diff_2row[2]);
                        }
                    } else {
                        return $status;
                    }
                } else {
                    return ["status" => "noNeedToChange"];
                }

            }
        } else {
            return '爬取失敗';
        }
    }

    /**
     *
     *處理讀取的json資料並存入資料庫
     * @return  執行後的狀態 [顯示訊息,$執行後相關訊息]
     */
    public function storeToTable($arrData)
    {
        //存入countries table
        $isSave = $this->storeCountryTable($this->getCountryCode($arrData));
        //回應執行狀態
        if ($isSave['status'] == 'saveSuccess') {
            //存入phones table
            $isSave = $this->storeToPhoneTable($arrData['id_to_countrycode']);
            if ($isSave['status'] == 'saveSuccess') {
                return ['執行成功', ['status' => 'saveSuccess']];
            } else {
                return ['失敗-存取存取電話碼至資料表,請手動處理資料庫', $isSave];
            }
        } else {
            return ['失敗-存取國家資料至資料表、尚未執行存取電話碼至資料表,請手動處理資料庫', $isSave];
        }
    }

/**
 *
 * 比較兩個讀取的json資料是否有差異
 * @return 返回差異 (array)[userinfo_country_code差異,id_to_countrycode差異]
 */
    public function compareStrArrDiff($arr, $arr2)
    {
        $isDiff = [true, true, true, true];
        $arrCC = $arr['userinfo_country_code'];
        $arr2CC = $arr2['userinfo_country_code'];
        $arrIC = $arr['id_to_countrycode'];
        $arr2IC = $arr2['id_to_countrycode'];
        unset($arrCC[0]);
        unset($arr2CC[0]);
        $newDataFromArrCC = array_diff_assoc($arrCC, $arr2CC);
        $deleteDataFromArr2CC = array_diff_assoc($arr2CC, $arrCC);

        $newDataFromArrIC = array_diff_assoc($arrIC, $arr2IC);
        $deleteDataFromArr2IC = array_diff_assoc($arr2IC, $arrIC);

        if ($newDataFromArrCC == []) {
            $isDiff[0] = false;
        }
        if ($deleteDataFromArr2CC == []) {
            $isDiff[1] = false;
        }
        if ($newDataFromArrIC == []) {
            $isDiff[2] = false;
        }
        if ($deleteDataFromArr2IC == []) {
            $isDiff[3] = false;
        }

        return [$isDiff,
            ['userinfo_country_code' => $newDataFromArrCC, 'id_to_countrycode' => $newDataFromArrIC], ['userinfo_country_code' => $deleteDataFromArr2CC, 'id_to_countrycode' => $deleteDataFromArr2IC],
        ];
    }

    /**
     *
     * 取得 國家代碼=>國家名稱
     * @return (array)國家代碼=>國家名稱
     */
    public function getCountryCode($arrData)
    {
        $userinfo_country_code = $arrData['userinfo_country_code'];
        $i = 0;
        $country_code = [];
        foreach ($userinfo_country_code as $key => $value) {
            if ($i > 0) {
                $country_code[$key] = substr($value, 0, strpos($value, '(') - 1);
            }
            $i++;
        }
        return $country_code;
    }

    /**
     *
     *將國家資料存入資料庫，不成功時嘗試執行資料回滾
     * @return 執行後的狀態與相關資訊
     */
    public function storeCountryTable($keyValues)
    {
        $i = 0;
        $level = 0;
        foreach ($keyValues as $key => $value) {
            try {
                if (count(Country::where('code', $key)->get()) == 0 && count(Country::where('name', $value)->get()) == 0) {
                    $level = 0;
                    $addCountry = new Country;
                    $addCountry->level = $level;
                    $addCountry->code = $key;
                    $addCountry->name = $value;
                    $addCountry->save();
                    $i++;
                }
            } catch (exception $e) {
                try {
                    $k = $i;
                    $i = 0;
                    foreach ($keyValues as $key => $value) {
                        if ($i >= $k) {
                            $isdestory = $this->destroyCountryTable($level, $key, $value);
                            if ($isdestory[0] == false) {
                                return ['status' => 'saveFailed', 'saveLavel' => $level, 'errorIndex' => $k, 'rollbackTo' => $i, 'errorInfo' => $isdestory[1]];
                            }
                        } else {
                            break;
                        }
                        $i++;
                    }
                } catch (Exception $ee) {
                    return ['status' => 'saveFailed', 'saveLavel' => $level, 'errorIndex' => $k, 'rollbackTo' => $i, 'errorInfo' => $e];

                }

                return ['status' => 'saveFailed', 'saveLavel' => $level, 'errorIndex' => $k, 'rollback' => true, 'errorInfo' => $e];
            }
            $i++;
        }
        return ['status' => 'saveSuccess', 'saveLavel' => $level, 'FailedFrom' => $i, 'alreadySaveindex' => $i - 1];
    }
    public function destoryToTable($arrData)
    {
        $arrCC = $arrData['userinfo_country_code'];
        $arrIC = $arrData['id_to_countrycode'];
        $level = 0;
        $i = 0;
        foreach ($arrCC as $key => $value) {
            $isSuccess = $this->destroyCountryTable($level, $key, $value);
            if ($isSuccess) {
                $i++;
            } else {
                return ['status' => 'deleteCountryFailed', 'errorIndex' => $i];
            }
        }
        $i;
        foreach ($arrIC as $key => $value) {
            $country = Country::where('code', $key)->latest('created_at')->first();
            $isSuccess = $this->destroyPhoneTable($key, $value, $country);
            if ($isSuccess) {
                $i++;
            } else {
                return ['status' => 'deletePhoneFailed', 'errorIndex' => $i];
            }
            return ['status' => 'deleteSuccess'];
        }
// return[]
    }

    /**
     *
     *刪除國家資料表中資料-指定國家代碼
     * @return 執行後的狀態與相關資訊
     */
    public function destroyCountryTable($level, $key, $value)
    {
        try {
            $country = Country::where('code', $key)->where('name', $value)->where('level', $level)->latest('created_at')->first();
            if (!$country == null) {
                $country->delete();
            }
        } catch (Exception $e) {
            return [false, $e];
        }
        return true;
    }

    /**
     *
     *將國際電話碼資料存入資料庫，不成功時嘗試執行資料回滾
     * @return 執行後的狀態與相關資訊
     */
    public function storeToPhoneTable($keyValues)
    {
        $i = 0;
        foreach ($keyValues as $key => $value) {
            try {
                $country = Country::where('code', $key)->latest('created_at')->first();
                if (count(PhoneCode::where('country_id', $country->id)->get()) == 0) {
                    $addPhone = new PhoneCode;
                    $addPhone->country_id = $country->id;
                    $addPhone->code = $value;
                    $addPhone->save();
                    $i++;
                }
            } catch (Exception $e) {

                try {
                    $k = $i;
                    $i = 0;
                    foreach ($keyValues as $key => $value) {
                        if ($i >= $k) {
                            $isdestory = $this->destroyPhoneTable($key, $value, $country);
                            if ($isdestory[0] == false) {
                                return ['status' => 'saveFailed', 'errorIndex' => $k, 'rollbackTo' => $i, 'errorInfo' => $isdestory[1]];

                            }
                        } else {
                            break;
                        }
                        $i++;
                    }
                } catch (Exception $ee) {
                    return ['status' => 'saveFailed', 'errorIndex' => $k, 'rollbackTo' => $i, 'errorInfo' => $e];
                }
            }
        }
        return ['status' => 'saveSuccess', 'alreadySaveindex' => $i];
    }
    /**
     *
     *刪除國際電話碼資料表中資料-指定國家主鍵(國際電話碼外鍵)
     * @return 執行後的狀態與相關資訊
     */
    public function destroyPhoneTable($key, $value, $country)
    {
        try {
            $phoneCode = PhoneCode::where('country_id', $country->id)->latest('created_at')->first();
            $phoneCode->delete();
        } catch (Exception $e) {
            return [false, $e];
        }
        return true;
    }

}
