<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Machine;
use App\Models\Shift;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\Sku;
use Illuminate\Support\Facades\DB;

class DatatablesController extends Controller
{
    //
    public function skuList(Request $request)
    {
        $columns = array(
            0 => 'created_at',
            1 => 'sku_name',
            2 => 'target',
            3 => 'th_H',
            4 => 'th_L',

        );
        $collection = DB::table('sku');;
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->sku_name;
                $nestedData[] = $row->target;
                $nestedData[] = $row->th_H;
                $nestedData[] = $row->th_L;
                $nestedData[] = view('modal.edit-sku', ['sku' => $row])->render();
                // $nestedData[] = view('modal.edit-parameter', ['parameters' => Parameters::all(), 'parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }

    public function addSKU(Request $request)
    {
        //
        $rules = [
            'sku_name' => 'required|max:255',
            'target' => 'required',
            'th_H' => 'required',
            'th_L' => 'required',
        ];
        $validatedData = $request->validate($rules);
        $affected_row = Sku::create($validatedData);
        // dd($affected_row);
        if ($affected_row) {
            return redirect('/sku')->with('success', 'New SKU has been added!');
        }
        return redirect('/sku')->with('failed', 'Adding SKU failed!');
    }
    public function editSKU(Request $request)
    {
        //
        $rules = [
            // 'id' => 'required',
            'target' => 'required',
            'th_H' => 'required',
            'th_L' => 'required',
        ];
        $validatedData = $request->validate($rules);
        $affected_row = Sku::where('id', $request->id)->update($validatedData);
        if ($affected_row) {
            return redirect('/sku')->with('success', 'SKU ' . $request->sku_name . ' has been edited!');
        }
        return redirect('/sku')->with('failed', 'Editing SKU failed!');
    }
    public function deleteSKU(Request $request)
    {
        $affected_row = Sku::where('id', $request->id)->delete();
        if ($affected_row) {
            return redirect('/sku')->with('success', 'SKU ' . $request->sku_name . ' has been deleted!');
        }
        return redirect('/sku')->with('failed', 'Deleting SKU failed!');
    }
    public function lineList(Request $request)
    {
        $columns = array(
            0 => 'created_at',
            1 => 'line_name',

        );
        $collection = DB::table('line');;
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->line_name;
                // $nestedData[] = 'hehe';
                $nestedData[] = view('modal.edit-line', ['line' => $row])->render();
                // $nestedData[] = view('modal.edit-parameter', ['parameters' => Parameters::all(), 'parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
    public function addLine(Request $request)
    {
        //
        $rules = [
            'line_name' => 'required|max:255',
        ];
        $validatedData = $request->validate($rules);
        $affected_row = Line::create($validatedData);
        // dd($affected_row);
        if ($affected_row) {
            return redirect('/setup')->with('success', 'New Line has been added!');
        }
        return redirect('/setup')->with('failed', 'Adding Line failed!');
    }
    public function deleteLine(Request $request)
    {
        $affected_row = Line::where('id', $request->id)->delete();
        if ($affected_row) {
            return redirect('/setup')->with('success', 'Line ' . $request->line_name . ' has been deleted!');
        }
        return redirect('/setup')->with('failed', 'Deleting Line failed!');
    }
    public function machineList(Request $request)
    {
        $columns = array(
            0 => 'created_at',
            1 => 'machine_name',

        );
        $collection = DB::table('machine');;
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->machine_name;
                // $nestedData[] = 'hehe';
                $nestedData[] = view('modal.edit-machine', ['machine' => $row])->render();
                // $nestedData[] = view('modal.edit-parameter', ['parameters' => Parameters::all(), 'parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
    public function addMachine(Request $request)
    {
        //
        $rules = [
            'machine_name' => 'required|max:255',
        ];
        $validatedData = $request->validate($rules);
        $affected_row = Machine::create($validatedData);
        // dd($affected_row);
        if ($affected_row) {
            return redirect('/setup')->with('success', 'New Machine has been added!');
        }
        return redirect('/setup')->with('failed', 'Adding Machine failed!');
    }
    public function deleteMachine(Request $request)
    {
        $affected_row = Machine::where('id', $request->id)->delete();
        if ($affected_row) {
            return redirect('/setup')->with('success', 'Machine ' . $request->machine_name . ' has been deleted!');
        }
        return redirect('/setup')->with('failed', 'Deleting Machine failed!');
    }
    public function shiftList(Request $request)
    {
        $columns = array(
            0 => 'created_at',
            1 => 'shift_name',

        );
        $collection = DB::table('shift');;
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->shift_name;
                $nestedData[] = $row->created_at;
                // $nestedData[] = 'hehe';
                $nestedData[] = view('modal.edit-shift', ['shift' => $row])->render();
                // $nestedData[] = view('modal.edit-parameter', ['parameters' => Parameters::all(), 'parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
    public function addShift(Request $request)
    {
        //
        $rules = [
            'shift_name' => 'required|max:255',
        ];
        $validatedData = $request->validate($rules);
        $affected_row = Shift::create($validatedData);
        // dd($affected_row);
        if ($affected_row) {
            return redirect('/setup')->with('success', 'New Shift has been added!');
        }
        return redirect('/setup')->with('failed', 'Adding Shift failed!');
    }
    public function deleteShift(Request $request)
    {
        $affected_row = Shift::where('id', $request->id)->delete();
        if ($affected_row) {
            return redirect('/setup')->with('success', 'Shift ' . $request->shift_name . ' has been deleted!');
        }
        return redirect('/setup')->with('failed', 'Deleting Shift failed!');
    }
    public function historicalLog(Request $request)
    {
        $line = $request->input('line');
        $machine = $request->input('machine');
        $shift = $request->input('shift');
        $sku = $request->input('sku');
        $columns = array(
            0 => 'created_at',
            1 => 'line_name',
            2 => 'machine_name',
            3 => 'shift_name',
            4 => 'sku_name',
            5 => 'weight',
            6 => 'target',
            7 => 'th_H',
            8 => 'th_L',
            9 => 'status',

        );
        $collection = DB::table('historical_log');;
        if ($line) {
            $line_name = Line::where('id', $line)->first()->line_name;
            $collection = $collection->where('line_name', $line_name);
        }
        if ($machine) {
            $machine_name = Machine::where('id', $machine)->first()->machine_name;
            $collection = $collection->where('machine_name', $machine_name);
        }
        if ($shift) {
            $shift_name = Shift::where('id', $shift)->first()->shift_name;
            $collection = $collection->where('shift_name', $shift_name);
        }
        if ($sku) {
            $sku_name = Sku::where('id', $sku)->first()->sku_name;
            $collection = $collection->where('sku_name', $sku_name);
        }
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->line_name;
                $nestedData[] = $row->machine_name;
                $nestedData[] = $row->shift_name;
                $nestedData[] = $row->sku_name;
                $nestedData[] = $row->weight;
                $nestedData[] = $row->target;
                $nestedData[] = $row->th_H;
                $nestedData[] = $row->th_L;
                $nestedData[] = $row->status;
                // $nestedData[] = 'hehe';
                // $nestedData[] = view('modal.edit-shift', ['shift' => $row])->render();
                // $nestedData[] = view('modal.edit-parameter', ['parameters' => Parameters::all(), 'parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
}
