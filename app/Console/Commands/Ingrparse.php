<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Library\IngredientParser;

class Ingrparse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ingr:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ingredients = DB::table('ingredients')->where('parsed','false')->get();
        foreach($ingredients as $ingredient){
            $ing_line = $ingredient->Ingredient_line;
            DB::table('ingredients')->where('id',$ingredient->id)->update(['parsed' => true]);
            $ing_parser = new IngredientParser;
            $data_array = $ing_parser->parser_ingredient($ing_line);
            DB::table('ingredients')->where('id',$ingredient->id)->update(['name' => $data_array["name"]]);
            DB::table('ingredients')->where('id',$ingredient->id)->update(['quantity' => $data_array["quantity"]]);
            DB::table('ingredients')->where('id',$ingredient->id)->update(['measure' => $data_array["unit"]]);
        }
    }
}
