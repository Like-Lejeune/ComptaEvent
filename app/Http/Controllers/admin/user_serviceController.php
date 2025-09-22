<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Tools;
use Illuminate\Database\QueryException;
use App\Models\Service;
use App\Models\Profile;

class user_serviceController extends Controller
{

    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function userlist()
    {
        $nbuser = User::count();
        $nbuserUnactive = User::where('status', '!==', 1)->count();
        return view('admin.listUser')->with('nbuser',$nbuser)->with('nbuserUnactive',$nbuserUnactive);
    }

    public function updateUser_(string $id)
    {
        $user = User::where('id', $id)->first();
        $user_service = DB::table('services')
        ->join('user_service', 'id_service', '=', 'service_id')
        ->where('user_id', '=',$id)
        ->get();
        return view('admin.updateUser')->with('user',$user)->with('user_service',$user_service);
    }

    public function formUser()
    {
        //

        try {

            $profiles = Profile::all();
            $service = service::orderby('s_name', 'ASC')->get();
            return view('admin.formulaireUsers')->with('services',$service)->with('profiles',$profiles);


        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }

    // Create User -- Type User //

  public function nouvelUser(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8',
            'profil_id'=>'required',
            'service_id'=>'required',
            'type' => 'nullable|in:super,admin,user',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Veuillez corriger les erreurs suivantes :',
                'errors' => $validator->errors()
            ], 400);
        }

        // Définir les valeurs par défaut si nécessaire
        $password = $request->input('password')
            ? $this->tools->krypt($this->tools->controle_space($request->input('password')))
            : $this->tools->krypt('Compta2024');

        $type = $request->input('type') ?? 'user';
        $phone = $request->input('phone') ?? '';
        $status = $request->input('status') ?? '0';

        // Génération automatique du matricule
        $prefix = 'MA'; // Préfixe pour le matricule
        $year = substr(date('Y'), -2); // Année courante
        $uniqueId = str_pad(User::max('id') + 1, 3, '0', STR_PAD_LEFT); // ID incrémenté avec 3 chiffres
        $matricule = "{$prefix}-{$year}-{$uniqueId}";

        // Création de l'utilisateur
        $user = new User();
        $user->name = $this->tools->controle_space($request->input('name'));
        $user->email = $this->tools->controle_space($request->input('email'));
        $user->password = $password;
        $user->type = $type;
        $user->phone = $phone;
        $user->status = $status;
        $user->matricule = $matricule;
        $user->save();

        // Insertion des services associés (si fournis)
        if ($request->has('service')) {
            foreach ($request->input('service') as $choice) {
                DB::table('user_service')->insert([
                    'service_id' => $choice,
                    'user_id' => $user->id
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Utilisateur ajouté avec succès.');
    } catch (QueryException $e) {
        return response()->json([
            'message' => 'Une erreur est survenue lors de la création de l’utilisateur.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function updateUser(Request $request, string $id)
    {
        //

        try {
            $user = DB::table('users')
                ->where('id', $id)
                ->first();

            if ($user) {
                DB::table('users')
                    ->where('id', $id)
                    ->update(array(
                        'name' => $request->input('name') !== null ? $this->tools->controle_space($request->input('name')) : $user->name,
                        'email' => $request->input('email') !== null ? $this->tools->controle_space($request->input('email')) : $user->email,
                        'phone' => $request->input('phone') !== null ? $this->tools->controle_space($request->input('phone')) : $user->email,
                        'password' => $this->tools->krypt($request->input('password')) !== null ? $this->tools->krypt($this->tools->controle_space($request->input('password'))) : $user->password,
                        'type' => $request->input('type') !== null ? $this->tools->controle_space($request->input('type')) : $user->type,
                        'updated_at' => $this->tools->HeureLocale(),
                    ));
            }

            if ($request->has('service')) {
                $newChoices = $request->input('service'); // Les nouveaux choix sélectionnés

                $existingChoices = DB::table('user_service')
                    ->where('user_id', $id)
                    ->pluck('service_id') // Récupère uniquement les valeurs de 'service_id'
                    ->toArray();

                // Identifier les choix à ajouter
                $choicesToAdd = array_diff($newChoices, $existingChoices);

                // Identifier les choix à supprimer
                $choicesToDelete = array_diff($existingChoices, $newChoices);

                // Ajouter les nouveaux choix
                foreach ($choicesToAdd as $choice) {
                    DB::table('user_service')->insert([
                        'service_id' => $choice,
                        'user_id' => $id,
                    ]);
                }

                // Supprimer les choix qui ne sont plus sélectionnés
                if (!empty($choicesToDelete)) {
                    DB::table('user_service')
                        ->where('user_id', $id)
                        ->whereIn('service_id', $choicesToDelete)
                        ->delete();
                }
            }

            return redirect()->back()->with('success', 'You have successfully update user.');

        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }

    public function destroyUser(string $id)
    {

        try {
            $user = DB::table('users')
                ->where('id', $id)
                ->first();
            if ($user) {
                $user = DB::table('users')
                    ->where('id', $id)
                    ->delete();

                $user = DB::table('user_service')
                    ->where('user_id', $id)
                    ->delete();


                    return redirect()->back()->with('success', 'You have successfully update user.');
            }
            return response()->json(['message' => 'user not found'], 404);
        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }
        public function ActivateOrdesactivateUser(string $id)
    {
        try {
            // Récupérer l'utilisateur par son ID
            $user = DB::table('users')->where('id', $id)->first();

            // Vérifier si l'utilisateur existe
            if (!$user) {
                return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
            }

            // Inverser le statut actuel
            $newStatus = $user->status == 1 ? 0 : 1;

            // Mettre à jour le statut de l'utilisateur
            DB::table('users')->where('id', $id)->update(['status' => $newStatus]);

            // Retourner une réponse réussie
            $message = $newStatus == 1 ? 'Utilisateur activé avec succès.' : 'Utilisateur désactivé avec succès.';
            return response()->json(['message' => $message], 200);

        } catch (QueryException $e) {
            // Gérer les erreurs de base de données
            return response()->json(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        //

        try {

            $user = DB::table('users')
                ->where('id', $id)
                ->select("*")
                ->first();
            $roles = DB::table('services')
                    ->join('user_service', 'service_id', '=', 'id_service')
                    ->where('user_id', $user->id)
                    ->pluck('services');
            $idRole= DB::table('roles')
                    ->join('user_role', 'idRole', '=', 'role_id')
                    ->where('user_id', $user->id)
                    ->pluck('idRole');

                    $user->roles = $roles;
                    $user->role_id = $idRole;

            if ($user) {
                return response()->json($user);
            }
            return response()->json(['message' => 'User not found'], 404);
        } catch (QueryException $e) {

            return response()->json($e->getMessage());
        }
    }

}
