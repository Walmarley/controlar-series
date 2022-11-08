<?php

namespace App\Http\Controllers;

use App\Http\Requests\SerieFormRequest;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()->orderby('nome')->get();
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        $request->session()->forget('mensagem.sucesso');

        return view('series.index')-> with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }
    public function create()
    {
        return view('series.create');
    }

    public function store(SerieFormRequest $request)
    {
        $serie = Serie::create($request->all());

        return redirect(route('series.index'))
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SerieFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }

    public function destroy(Serie $series)
    {
        $series->delete();
        // Serie::destroy($request->series);
        // $request->session()->put('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }
}
