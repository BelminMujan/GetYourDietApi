<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Diet;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DietRequest;

class DietController extends Controller {
    protected $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public function requestDiet(Request $request){
//        Log::Info($request->all());
        $data = $request->all();
        $data['status'] = 1;
        $diet_request = DietRequest::create($data);
        $this->generateDiet($diet_request['id']);
    }

    public function getAllDietRequests(Request $request){
        $data = DietRequest::with('status')->get();
        return response()->json([
            'dietRequests' => $data
        ], 200);
    }

    public function deleteDietRequest() {
        DietRequest::destroy(request()->id);
        return response()->json([
            'message' => 'Diet request was deleted successfully!'
        ], 200);
    }

    public function changeDietRequestStatus(Request $request){
        Log::Info($request->all());
        $diet_request = DietRequest::find(intval($request->dietRequestId));
        $diet_request->status = intval($request->newStatusId);
        $diet_request->save();
        return response()->json([
            'message' => 'Diet Request status changed successfully!'
        ], 200);
    }

    public function getDiet(){
        $diet = Diet::where('diet_request_id', request()->id)->firstOrFail();
        return response()->json([
            'diet' => $diet
        ], 200);
    }
    public function generateDiet($request_id = NULL) {
        $diet = Diet::where('diet_request_id',request()->id)->first();
        if(!$diet){
            $diet = new Diet();
            $diet->diet_request_id = $request_id;
        }
        $no_meals = 4;
        $no_weeks = 2;
        $d = NULL;
        for($w_no=1; $w_no <= $no_weeks; $w_no++) {
            foreach ($this->days as $day){
                for($m_no=1; $m_no <= $no_meals; $m_no++){
                    $meal = [
                        [
                            'food' => Food::find(rand(0, 50)),
                            'quantity' => '100'
                        ],
                        [
                            'food' => Food::find(rand(0, 50)),
                            'quantity' => '80'
                        ],
                    ];
                    $d['Week '.$w_no][$day]['Meal '.$m_no] = $meal;
                }
            }
        }

        $diet->diet = $d;
        $diet->save();
    }

    public function generatePdf($data)
    {
        $pdf = PDF::loadView('diet_pdf', ['data' => $data, 'title' => 'User']);
        $path = storage_path('pdf/');
        $fileName = 'test' . '.' . 'pdf' ;
        $pdf->save($path . '/' . $fileName);
    }
}
