<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SeriesFormRequest;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        // $series = Series::query()->orderby('nome')->get(); //pega e ordena (deveria)
        // $series = Series::all(); //Pega Tudo
        $series = Series::with(['seasons'])->get();

        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        $request->session()->forget('mensagem.sucesso');

        return view('series.index')-> with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }
    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $serie = Series::create($request->all());
        $seasons = [];

        for($i = 1; $i <= $request->seasonsQty; $i++){
            $seasons[] = [
                'series_id' => $serie->id,
                'number' => $i,
            ];
        }
        Season::insert($seasons);

        foreach ($serie->seasons as $season){
            for($j = 1; $j <= $request->episodesPerSeason; $j++){
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j,
                ];
            }
        }
        Episode::insert($episodes);

        return redirect(route('series.index'))
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }


    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }

    public function destroy(Series $series)
    {
        $series->delete();
        // Series::destroy($request->series);
        // $request->session()->put('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }
}
