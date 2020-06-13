<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VisibleTablesController extends Controller
{
    /*
    * get API call to get a list of all visible tables
    */
    public function getAll() {
        try {
            $visibleTables = $this->getData();
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        return response()->json($visibleTables);
        
    }

    /*
    * Display a list of all visible tables
    */
    public function display() {
        $visibleTables = $this->getData();
        return view('displayAllTables', ['data'=>$visibleTables]);
    }

    /*
    * Get visible table data.
    * getData function calls hungryhungry json to get a list of rooms and table, and returns a list of visible tables
    *
    * return visibleTables: an array of visible tables
    */
    private function getData() {
        $url = 'https://hungryhungry.com/helping-hospo/hh_test_tabledata.json';
        $jsonData = file_get_contents($url);
        // Store the table data json file locally
        Storage::disk('local')->put('hh_test_tabledata.json', $jsonData);
        // alt
        // file_put_contents('hh_test_tabledata.json', file_get_contents($url));
        $data = json_decode($jsonData);

        $visibleTables = [];
        if($data) {
            foreach ($data as $room) {
                foreach ($room->tables as $tableID => $tableData) {
                    if($tableData->visible) {
                        $visibleTables[] = [
                            'room' => $room->name,
                            'tableID' => $tableID,
                            'tableName' => $tableData->name,
                            'QRCodePath' => 'https://dev.hungryhungry.com/oceana2/menu?locationID=1995257&tableID='.$tableID,
                        ];
                    }
                }
            }
        }
        
        return $visibleTables;
    }
}
