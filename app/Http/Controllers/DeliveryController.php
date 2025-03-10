<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Feeship;

class DeliveryController extends Controller
{
    public function update_delivery(Request $request)
    {
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'], '.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }

    public function select_feeship()
    {
        $feeship = Feeship::orderBy('fee_id', 'desc')->get();
        $output = '';
        $output.= '<div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tên thành phố</th>
                                <th>Tên quận huyện</th>
                                <th>Tên xã phường</th>
                                <th>Phí ship</th>
                            </tr>
                        </thead>

                        <tbody>
                        ';
                            foreach($feeship as $key => $fee)
                            {
                                $output.= '
                                    <tr>
                                        <td>'.$fee->city->name_city.'</td>
                                        <td>'.$fee->province->name_quanhuyen.'</td>
                                        <td>'.$fee->ward->name_xaphuong.'</td>
                                        <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship, 0, ',', '.').'</td>
                                    </tr>
                                ';
                            }
            $output.= '
                        </tbody>
                    </table>
                </div>';
            
            echo $output;
    }

    public function insert_delivery(Request $request)
    {
        $data = $request->all();
        $fee_ship = new Feeship;
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['ward'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }

    public function delivery(Request $request)
    {
        $city = City::orderBy('matp', 'asc')->get();
    
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        if($data['action'])
        {
            $output = '';
            if($data['action'] == 'city')
            {
                $select_province = Province::where('matp', $data['ma_id'])->orderBy('maqh', 'asc')->get();
                if ($select_province->isEmpty()) {
                    return response()->json(['error' => 'Không có quận huyện nào.']);
                }

                $output.='<option>-----Chọn quận huyện-----</option>';
                foreach($select_province as $key => $province)
                {
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }
            elseif($data['action'] == 'province')
            {
                $select_ward = Ward::where('maqh', $data['ma_id'])->orderBy('xaid', 'asc')->get();
                if ($select_ward->isEmpty()) {
                    return response()->json(['error' => 'Không có xã phường nào.']);
                }

                $output.='<option>-----Chọn xã phường-----</option>';
                foreach($select_ward as $key => $ward)
                {
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
        }

        echo $output;
    }
}
