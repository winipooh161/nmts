<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\TeamRegistration;
use App\Models\SoloRegistration;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Главная страница дисциплин";

        $games = Game::all(); // Fetch all games
        $user = Auth::user(); // Get the authenticated user
        // Fetch all games the user has registered for (solo or team)
        $soloRegistrations = SoloRegistration::where('user_id', $user->id)->pluck('game_id')->toArray();
        $teamRegistrations = TeamRegistration::where('user_id', $user->id)->pluck('game_id')->toArray();
        // Merge the solo and team registrations into one array
        $registeredGames = array_merge($soloRegistrations, $teamRegistrations);
        // Fetch the number of games the user has registered for
        $totalRegistrations = count($registeredGames);
        // Pass the total number of registrations and the registered games to the view
        return view('home', compact('games', 'totalRegistrations', 'registeredGames', 'title'));
    }
    public function policy()
    {
        $title = "Политика ";
        return view('policy', compact( 'title'));
    }
    
}
