<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeerRequest;
use App\Services\PunkapiService;
use Illuminate\Http\Request;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        $filters = $request->validated();
        $beers = $service->getBeers(...$filters);
        $meals = Meal::all();
        return Inertia::render('Beers', [
            'beers' => $beers,
            'meals' => $meals,
            'filters' => $filters
        ]);
    }

    public function export(BeerRequest $request, PunkapiService $service)
    {
        $filename = "cervejas-encontradas-" . now()->format('Y-m-d - H_i') . ".xlsx";

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(), $filename)
        ])->dispatch($request->validated(), $filename);

        return redirect()->back()
            ->with('success', 'Seu arquivo foi enviado para processamento e em breve estará em seu email');
    }
}
