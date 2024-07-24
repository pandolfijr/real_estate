<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use App\Interfaces\Service\PropertyService;

use Exception;

class PropertyController extends Controller
{
    private $propertyService;

    public function __construct(
        PropertyService $propertyService
    ) {
        $this->propertyService = $propertyService;
    }

    /**
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $result = $this->propertyService->getProperties($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $properties = $result->getData();
            return response()->json(['properties' => $properties], 200);
        } catch (Exception $e) {
            return response()->json(['' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $customAttributes = [
            'description' => 'descrição',
            'type' => 'tipo',
            'purpose' => 'finalidade',
            'address' => 'endereço',
            'number' => 'número',
            'district' => 'bairro',
            'cep' => 'cep',
            'id_city' => 'cidade',
            'display_address' => 'Exibir Endereço',
            'id_locator' => 'Proprietário do Imóvel',
        ];

        $request->validate([
            'description' => 'required|min:3|max:100',
            'status' => 'required',
            'purpose' => 'required',
            'address' => 'required|min:4|max:100',
            'number' => 'required|min:1|max:5',
            'district' => 'required|max:20',
            'id_city' => 'required',
            'display_address' => 'required',
            'id_locator' => 'required',
            'type' => 'required',
            'images' => 'array',
        ], [], $customAttributes);

        $input = $request->all();
        if (!isset($input['images']) || isset($input['images']) && empty($input['images']))
            return response()->json(['message' => 'Você precisa enviar pelo menos uma foto'], 422);

        try {
            $result = $this->propertyService->saveProperty($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Imóvel salvo com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_property)
    {
        try {
            $result = $this->propertyService->getPropertyById($id_property);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $property = $result->getData();
            return response()->json(['property' => $property], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @param string $id_property
     * @return void
     */
    public function update(Request $request, string $id_property)
    {
        $customAttributes = [
            'description' => 'descrição',
            'type' => 'tipo',
            'purpose' => 'finalidade',
            'address' => 'endereço',
            'number' => 'número',
            'district' => 'bairro',
            'cep' => 'cep',
            'id_city' => 'cidade',
            'display_address' => 'Exibir Endereço',
            'id_locator' => 'Proprietário do Imóvel',
        ];

        $request->validate([
            'description' => 'required|min:3|max:100',
            'status' => 'required',
            'purpose' => 'required',
            'address' => 'required|min:4|max:100',
            'number' => 'required|min:1|max:5',
            'district' => 'required|max:20',
            'id_city' => 'required',
            'display_address' => 'required',
            'id_locator' => 'required',
            'type' => 'required',
            'images' => 'array',
        ], [], $customAttributes);

        $input = $request->all();
        try {
            $result = $this->propertyService->updateProperty($input, $id_property);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(["message" => "Imóvel alterado com sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_property
     * @return JsonResponse
     */
    public function destroy(string $id_property): JsonResponse
    {
        try {
            $result = $this->propertyService->deleteProperty($id_property);
            var_dump($result);
            exit;
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['Imóvel removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_property
     * @return JsonResponse
     */
    public function restore(string $id_property): JsonResponse
    {
        try {
            $result = $this->propertyService->restoreProperty($id_property);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['Imóvel removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updatePicture(Request $request, $id_property)
    {
        try {
            $input = $request->all();
            $result = $this->propertyService->updateImageProperty($input, $id_property);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['Imagem alterada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getPropertiesByIdLocator(string $id_property)
    {
        try {
            $result = $this->propertyService->getPropertiesByIdLocator($id_property);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $properties = $result->getData();
            return response()->json(['properties' => $properties], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @return View
     */
    public function total(): JsonResponse
    {
        try {
            $result = $this->propertyService->getTotalProperties();
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $properties = $result->getData();
            return response()->json(['properties' => $properties], 200);
        } catch (Exception $e) {
            return response()->json(['' => $e->getMessage()], 500);
        }
    }
}
