<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\PeopleService;
use App\Models\People;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    private $peopleService;
    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(People $people)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, People $people)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $people)
    {
        //
    }

    public function getPeopleByCpf(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $result = $this->peopleService->getPeopleByCpf($input['cpf']);
            if(!$result->success())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $people = $result->getData();

            return response()->json(['people' => $people], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
