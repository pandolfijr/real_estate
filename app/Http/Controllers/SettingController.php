<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\SettingService;
use App\Models\Setting;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private $settingService;

    public function __construct(
        SettingService $settingService
    ) {
        $this->settingService = $settingService;
    }
    public function index()
    {
        try {
            $result = $this->settingService->getSettings();
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $settings = $result->getData();
            return response()->json(['settings' => $settings], 200);
        } catch (Exception $e) {
            return response()->json(['' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, string $id_setting)
    {
        $request->validate([
            'fantasy_name' => 'required|min:3|max:30',
            'company_name' => 'required|min:3|max:50',
            'owner_name' => 'required|min:3|max:100',
            'address' => 'required|min:4|max:100',
            'number' => 'required|min:1|max:5',
            'first_telephone' => 'required|max:11',
            'first_whatsapp' => 'required|min:3|max:11',
            'id_city' => 'required|min:2|max:2',
        ]);

        $input = $request->all();

        try {
            $result = $this->settingService->updateSetting($input, $id_setting);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(["message" => "Configuração alterada com sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_setting)
    {
        try {
            $result = $this->settingService->getSettingById($id_setting);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $setting = $result->getData();
            return response()->json(['setting' => $setting], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
