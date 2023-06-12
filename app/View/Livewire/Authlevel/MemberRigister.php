<?php

namespace App\View\Livewire\Authlevel;

use App\Models\City;
use App\Models\Country;
use App\Models\PhoneCode;
use App\Models\Road;
use App\Models\Town;
use Livewire\Component;

class MemberRigister extends Component
{
    public $locale;
    public $pZone;
    public $pCountry;
    public $pCountryId;
    public $city;
    public $cityId;
    public $town;
    public $townId;
    public $road;
    public $roadId;
    public $userCity;
    public $userCityId;
    public $userTown;
    public $userTownId;
    public $userRoad;
    public $userRoadId;

    public function cityChangetown()
    {

        //取得city選單改變值在資料庫中的id
        $this->userCityId = $this->valueGetId($this->cityId, $this->userCity);
        //更動town、road選單的選擇項目
        //取得目前city值所對應的所有鄉政區
        $town = Town::where('city_id', $this->userCityId)->get();
        //延續上個結果所得的第一個鄉政區，取得它對應的所有道路
        $road = Road::where('town_id', $town[0]->id)->get();
        //更新使用者選擇city項目後連動town、road選單項目的變化
        $temp = $this->getSelectArr($town);
        $this->town = $temp[0];
        $this->townId = $temp[1];
        $temp = $this->getSelectArr($road);
        $this->road = $temp[0];
        $this->roadId = $temp[1];
        //更新使用者被動選擇的town、road選單項目在資料庫中的id
        $this->userTownId = $town[0]->id;
        $this->userRoadId = $road[0]->id;

    }
    public function townChangeRoad()
    {

        //取得town選單改變值在資料庫中的id
        $this->userTownId = $this->valueGetId($this->townId, $this->userTown);
        //更動road選單的選擇項目
        //取得目前town值所對應的所有鄉政區
        $road = Road::where('town_id', $this->userTownId)->get();
        //更新使用者選擇city項目後連動road選單項目的變化
        $temp = $this->getSelectArr($road);
        $this->road = $temp[0];
        $this->roadId = $temp[1];
        //更新使用者被動選擇的road選單項目在資料庫中的id
        $this->userRoadId = $road[0]->id;
    }
    public function valueGetId($valueArr, $value)
    {
        return $valueArr[$value];
    }
    public function mount()
    {
        $this->pZone = ['02', '03', '037', '04', '049', '05', '06', '07', '08', '082', '0826', '0836', '089'];
        //國際電話碼
        //當前國家為預設
        $countryCode = substr($this->locale, strpos($this->locale, '_') + 1, 3 * 3);
        $country = Country::where('code', $countryCode)->first();
        $phoneCodequery = PhoneCode::where('country_id', $country->id)->first();
        $i = 0;
        $this->pCountry[$i] = $country->name . ' (' . $phoneCodequery->code . ')';
        $this->pCountryId[$i++] = $phoneCodequery->id;
        $phoneCodequery = PhoneCode::orderBy('code', 'asc')->get();
        //其他國家
        foreach ($phoneCodequery as $key) {
            // dd($key);
            $this->pCountry[$i] = Country::find($key->country_id)->name . ' (' . $key->code . ')';
            $this->pCountryId[$i] = $key->id;
            $i++;
        }
        //地址-城市
        $city = City::where('country_id', $country->id)->get();
        $temp = $this->getSelectArr($city);
        $this->city = $temp[0];
        $this->cityId = $temp[1];
        //地址-鄉政區
        $town = Town::where('city_id', $city[0]->id)->get();
        $temp = $this->getSelectArr($town);
        $this->town = $temp[0];
        $this->townId = $temp[1];
        //地址-道路
        $road = Road::where('town_id', $town[0]->id)->get();
        $temp = $this->getSelectArr($road);
        $this->road = $temp[0];
        $this->roadId = $temp[1];
        $this->userCity = 0;
        $this->userTown = 0;
        $this->userRoad = 0;
        $this->userCityId = $this->valueGetId($this->cityId, $this->userCity);
        $this->userTownId = $this->valueGetId($this->townId, $this->userTown);
        $this->userRoadId = $this->valueGetId($this->roadId, $this->userRoad);

    }
    public function getSelectArr($modelSrr)
    {
        $i = 0;
        foreach ($modelSrr as $key) {
            $showContainer[$i] = $key->name;
            $iDContainer[$i++] = $key->id;
        }
        return [$showContainer, $iDContainer];
    }
    public function render()
    {
        return view('livewire.authlevel.member-rigister');
    }
}