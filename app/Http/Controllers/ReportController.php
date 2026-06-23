<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Export::paginate();

        return Inertia::render('Reports', [
            'exports' => $reports
        ]);
    }

    public function show($export) {
        $export = Export::find($export);

        return Storage::download($export->file_name);
    }

    public function destroy($export)
    {
        $export = Export::find($export);

        if ($export) {
            Storage::delete($export->file_name);
            $export->delete();
        }

        return redirect()->back()
            ->with('success', 'Seu arquivo foi enviado para processamento e em breve estará em seu email');
    }
}
