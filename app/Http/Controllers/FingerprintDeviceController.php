<?php

namespace App\Http\Controllers;

use App\Models\FingerprintDevice;
use Illuminate\Http\Request;
use App\Services\ZKTecoService;  
use App\Jobs\PullFingerprintLogsJob;
use App\Models\EmpData;

class FingerprintDeviceController extends Controller
{
    // قائمة الأجهزة
    public function index()
    {
        $this->authorize('عرض الأجهزة'); // صلاحية عرض الأجهزة
        $devices = FingerprintDevice::all();
        return view('fingerprint_devices.index', compact('devices'));
    }

    // إضافة جهاز جديد
    public function store(Request $request)
    {
        $this->authorize('اضافة جهاز'); // صلاحية إضافة جهاز
        $request->validate([
            'ip_address' => 'required|ip|unique:fingerprint_devices,ip_address',
            'port' => 'nullable|integer',
            'type' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        FingerprintDevice::create($request->all());
        return back()->with('success','تم إضافة الجهاز بنجاح');
    }

// تعديل جهاز بصمة
public function update(Request $request, $id)
{
    $this->authorize('تعديل جهاز');

    $device = FingerprintDevice::findOrFail($id);

    $request->validate([
        'ip_address' => 'required|ip|unique:fingerprint_devices,ip_address,' . $device->id,
        'port' => 'nullable|integer',
        'type' => 'required|string',
        'is_active' => 'nullable|boolean',
    ]);

    $device->update($request->all());

    return back()->with('success', "تم تعديل الجهاز {$device->ip_address} بنجاح");
}

// حذف جهاز بصمة
public function destroy($id)
{
    $this->authorize('حذف جهاز');

    $device = FingerprintDevice::findOrFail($id);
    $device->delete();

    return back()->with('success', "تم حذف الجهاز {$device->ip_address} بنجاح");
}


    // تفعيل / إيقاف الجهاز
    public function toggle($id)
    {
        $this->authorize('تعديل جهاز'); // صلاحية تعديل حالة الجهاز
        $device = FingerprintDevice::findOrFail($id);
        $device->is_active = !$device->is_active;
        $device->save();
        return back()->with('success', 'تم تحديث حالة الجهاز');
    }

    // اختبار اتصال بالجهاز
    public function testConnection($id, ZKTecoService $service)
    {
        $this->authorize( 'اختبار اتصال الجهاز'); // صلاحية اختبار الجهاز
        $device = FingerprintDevice::findOrFail($id);

        try {
                    /** @var \App\Services\ZKTecoService\ZKDevice $zk */

            $zk = $service->getZKInstance($device);
            $connected = $zk->connect(1); // timeout قصير
            $info = $connected ? $zk->getDeviceInfo() : null;
            $zk->disconnect();

            if ($info) return back()->with('success', "الجهاز {$device->ip_address} متصل ✅");

            return back()->with('error', "الجهاز {$device->ip_address} غير متصل ❌");

        } catch (\Exception $e) {
            return back()->with('error', "خطأ أثناء الاتصال: ".$e->getMessage());
        }
    }

    // Dashboard الأجهزة (خفيف)
    public function dashboard()
    {
$this->authorize('عرض أجهزة البصمة'); // بدل "عرض لوحة الأجهزة"
        $devices = FingerprintDevice::all();
        return view('fingerprint_devices.dashboard', compact('devices'));
    }

    
    // API صغير لجلب حالة Online/Offline
    public function status(ZKTecoService $service)
    {
$this->authorize('عرض أجهزة البصمة'); 
        $devices = FingerprintDevice::all();
        $result = [];

        foreach($devices as $device){
            $online = cache()->remember("device_{$device->id}_online", 10, function() use($service, $device){
                try {
                                        /** @var \App\Services\ZKTecoService\ZKDevice $zk */

                    $zk = $service->getZKInstance($device);
                    $connected = $zk->connect(1); // timeout قصير جداً
                    $info = $connected ? $zk->getDeviceInfo() : null;
                    $zk->disconnect();
                    return (bool)$info;
                } catch (\Exception $e) {
                    return false;
                }
            });

            $result[] = ['id'=>$device->id, 'online'=>$online];
        }

        return response()->json($result);
    }

    // سحب البيانات من الجهاز في الخلفية
    public function pullLogs($id)
    {
$this->authorize('سحب بيانات البصمة'); 
        $device = FingerprintDevice::findOrFail($id);
        PullFingerprintLogsJob::dispatch($device);
        return back()->with('success', "تم بدء سحب البيانات من الجهاز {$device->ip_address} في الخلفية");
    }

    // صفحة ربط الموظفين بالأجهزة
    public function bindEmployeesView()
    {
        $this->authorize('ربط الأجهزة بالموظفين'); // صلاحية ربط الأجهزة
        $employees = EmpData::with('fingerprintDevices')->paginate(50);
        $devices = FingerprintDevice::all();
        return view('fingerprint_devices.bind_employees', compact('employees', 'devices'));
    }

    // حفظ ربط الموظفين بالأجهزة
    public function saveEmployeeDevices(Request $request, $id)
    {
        $this->authorize('ربط الأجهزة بالموظفين'); // صلاحية حفظ الربط
        $emp = EmpData::findOrFail($id);
        $emp->fingerprintDevices()->sync($request->devices ?? []);
        return back()->with('success','تم حفظ ربط الأجهزة بالموظف بنجاح');
    }





}
