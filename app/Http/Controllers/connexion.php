<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Evenement;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use app\Mail\WelcomeUserMail;
class connexion extends Controller
{
    public function controle_space($chaine)
    {
      $chaine = trim($chaine);
      $chaine = str_replace("###antiSlashe###t", " ", $chaine);
      $chaine = preg_replace("!\s+!", " ", $chaine);
      $chaine = htmlspecialchars($chaine);
      return $chaine;
    }
    public function connexion()
    {
        return view('admin.Menu');
    }
    public function identification()
    {
        return view('singin');
        //return view('inscription');
    }
    public function inscription()
    {
        return view('inscription');
    }

    public function validation_inscription_(Request $request)
    {
        // Validation entrée
        $validated = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
           // 'affiliate_code' => 'nullable|exists:users,affiliate_code'
        ], [
           // 'affiliate_code.exists' => 'Le code d’affiliation est invalide.'
        ]);
    
        // // Récupérer le parrain si code renseigné
        // $affiliate = null;
        // if (!empty($validated['affiliate_code'])) {
        //     $affiliate = User::where('affiliate_code', $validated['affiliate_code'])->first();
        // }
    
        // Nombre d'utilisateurs
        $nb = User::where('type', 'user')->count() + 1;
    
        // Création utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => 'user',
            'status' => 1,
            'matricule' => 'Compta'.$nb."-".substr(date('Y'), 2, 2),
           // 'affiliate_id' => $affiliate ? $affiliate->id : null,
           //'affiliate_code' => 'AFF-' . rand(10000, 99999),
        ]);
    
        // Envoi email de bienvenue
         $user->notify(new WelcomeUserMail($user));
        return back()->with('message2', 'Utilisateur créé avec succès ! Email envoyé.');
    }

      public function validation_inscription(Request $request)
    {
        // Validation
        $validated = $request->validate([
            // user
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',

            // evenement
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'budget_total' => 'required|numeric|min:0',

            // services (optionnel)
            'services' => 'nullable|array|max:4',
            'services.*.s_name' => 'required_with:services|string|max:60',
            'services.*.s_description' => 'nullable|string',
            'services.*.s_budget' => 'nullable|numeric|min:0',
            'services.*.s_solde' => 'nullable|numeric|min:0',
            // s_photo est volontairement ignoré ici (pas de rule pour les fichiers)
        ], [
            'services.max' => 'Vous pouvez ajouter au maximum 4 services.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.'
        ]);

        // Utiliser une transaction pour garantir la consistance
        DB::beginTransaction();
        try {
            // 1) Création de l'utilisateur
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'type' => 'user',
                'country' => $validated['country'] ?? null,
                'phone' => $validated['phone'] ?? '',
                // si tu as d'autres champs par défaut, ajoute-les ici
            ]);

            // 2) Création de l'événement lié à l'utilisateur
            $evenement = Evenement::create([
                'utilisateur_id' => $user->id,
                'nom' => $validated['nom'],
                'description' => $validated['description'] ?? null,
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'budget_total' => $validated['budget_total'],
                'annee' => $validated['annee'] ?? null,
            ]);

            // 3) Création des services (si fournis)
            $services = $request->input('services', []);
            if (is_array($services) && count($services) > 0) {
                foreach ($services as $idx => $s) {
                    // Respecter la limite de 4 (déjà validée), défensif:
                    if ($idx >= 4) break;

                    // Création du service : on n'utilise pas le champ s_photo (ignoré)
                    Service::create([
                        // si ta table utilise 'id_service' comme PK, vérifie la propriété $primaryKey dans le modèle
                        'evenement_id' => $evenement->id,
                        's_name' => $s['s_name'] ?? '',
                        's_description' => $s['s_description'] ?? '',
                        's_budget' => isset($s['s_budget']) ? $s['s_budget'] : 0,
                        's_solde' => isset($s['s_solde']) ? $s['s_solde'] : 0,
                        's_photo' => '', // photo ignorée pour l'instant
                    ]);
                }
            }

            DB::commit();
            $user->notify(new WelcomeUserMail($user));
            return redirect()->back()->with('success', 'Inscription et événement créés avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('finalSubmit error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()->withInput()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.']);
        }
    }


    public function t_verification(Request $request)
    {   
        
      $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Identifiants incorrects');
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'Email non vérifié');
        }

        if ($user->status == 0) {
            return back()->with('error', 'Votre compte est inactif. Veuillez contacter l\'administrateur.');
        }

        // On tente la connexion
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Identifiants incorrects');
        }

        // Regénère la session pour plus de sécurité
        $request->session()->regenerate();

        // Redirection selon le type
        if ($user->type === 'admin' || $user->type === 'super') {
            return redirect()->route('administrator');
        }

        return redirect()->route('user_menu');
    }


    public function deconnexion()
    {
        auth()->logout();
        return redirect()->route('identification');
    }

//////////////////////////////////////////////////////////////////////////////////////
    //////// Reset password
/////////////////////////////////////////////////////////////////////////////////

    public function reset_password()
    {

        return view('reset_password');
        // return view('template.preloader'); 
    }


    
    //////////////////////////////////////////////////////////////////////////////////////
    //////// Fonctions qui récupères les infos sur le pays et tous les pays 
    /////////////////////////////////////////////////////////////////////////////////
    public  function get_country()
    {

        $ip = $this->get_ip();
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $output = @$ipdat->geoplugin_countryName;
        return $output;
    }

    public function get_ip()
    {
        $mainIp = '';
        if (getenv('REMOTE_ADDR'))
            $mainIp = getenv('REMOTE_ADDR');
        else
            $mainIp = 'UNKNOWN';
        return $mainIp;
    }
    public function all_country()
    {

        // All countries
        // length 252
        $countries_list = array(
            "Afghanistan",
            "Aland Islands",
            "Albania",
            "Algeria",
            "American Samoa",
            "Andorra",
            "Angola",
            "Anguilla",
            "Antarctica",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Aruba",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bermuda",
            "Bhutan",
            "Bolivia",
            "Bonaire, Sint Eustatius and Saba",
            "Bosnia and Herzegovina",
            "Botswana",
            "Bouvet Island",
            "Brazil",
            "British Indian Ocean Territory",
            "Brunei Darussalam",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Cayman Islands",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Christmas Island",
            "Cocos (Keeling) Islands",
            "Colombia",
            "Comoros",
            "Congo",
            "Congo, Democratic Republic of the Congo",
            "Cook Islands",
            "Costa Rica",
            "Cote D'Ivoire",
            "Croatia",
            "Cuba",
            "Curacao",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Falkland Islands (Malvinas)",
            "Faroe Islands",
            "Fiji",
            "Finland",
            "France",
            "French Guiana",
            "French Polynesia",
            "French Southern Territories",
            "Gabon",
            "Gambia",
            "Georgia",
            "Germany",
            "Ghana",
            "Gibraltar",
            "Greece",
            "Greenland",
            "Grenada",
            "Guadeloupe",
            "Guam",
            "Guatemala",
            "Guernsey",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Heard Island and Mcdonald Islands",
            "Holy See (Vatican City State)",
            "Honduras",
            "Hong Kong",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran, Islamic Republic of",
            "Iraq",
            "Ireland",
            "Isle of Man",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jersey",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, Democratic People's Republic of",
            "Korea, Republic of",
            "Kosovo",
            "Kuwait",
            "Kyrgyzstan",
            "Lao People's Democratic Republic",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libyan Arab Jamahiriya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macao",
            "Macedonia, the Former Yugoslav Republic of",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Martinique",
            "Mauritania",
            "Mauritius",
            "Mayotte",
            "Mexico",
            "Micronesia, Federated States of",
            "Moldova, Republic of",
            "Monaco",
            "Mongolia",
            "Montenegro",
            "Montserrat",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "Netherlands Antilles",
            "New Caledonia",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Niue",
            "Norfolk Island",
            "Northern Mariana Islands",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Palestinian Territory, Occupied",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Pitcairn",
            "Poland",
            "Portugal",
            "Puerto Rico",
            "Qatar",
            "Reunion",
            "Romania",
            "Russian Federation",
            "Rwanda",
            "Saint Barthelemy",
            "Saint Helena",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Martin",
            "Saint Pierre and Miquelon",
            "Saint Vincent and the Grenadines",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Sint Maarten",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "South Georgia and the South Sandwich Islands",
            "South Sudan",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Svalbard and Jan Mayen",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syrian Arab Republic",
            "Taiwan, Province of China",
            "Tajikistan",
            "Tanzania, United Republic of",
            "Thailand",
            "Timor-Leste",
            "Togo",
            "Tokelau",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Turks and Caicos Islands",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "United States Minor Outlying Islands",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Venezuela",
            "Viet Nam",
            "Virgin Islands, British",
            "Virgin Islands, U.s.",
            "Wallis and Futuna",
            "Western Sahara",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        );
        return $countries_list;
    }
}
