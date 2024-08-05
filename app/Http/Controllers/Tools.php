<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class Tools extends Controller
{

    private $tools;
    //
    protected $key;

    public function __construct()
    {
        $this->key = env('ENCRYPTION_KEY');

    }

    public function controle_space($chaine)
    {
        $chaine = trim($chaine);
        $chaine = str_replace("###antiSlashe###t", " ", $chaine);
        $chaine = preg_replace("!\s+!", " ", $chaine);
        $chaine = htmlspecialchars($chaine);
        return $chaine;
    }

    function generateSlug($title)
    {
        // Convertir le titre en minuscules
        $slug = mb_strtolower($title, 'UTF-8');

        // Supprimer les caractères spéciaux
        $slug = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $slug);

        // Remplacer les espaces par des tirets
        $slug = preg_replace('/[\s]+/u', '-', $slug);

        // Supprimer les tirets en début et fin de chaîne
        $slug = trim($slug, '-');

        // Gérer les caractères accentués
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);

        // Supprimer les caractères non alphanumériques
        $slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);

        // Convertir les espaces en tirets
        $slug = str_replace(' ', '-', $slug);

        // Convertir plusieurs tirets consécutifs en un seul tiret
        $slug = preg_replace('/-+/', '-', $slug);

        // Tronquer le slug si nécessaire (par exemple, à 100 caractères)
        $slug = mb_substr($slug, 0, 100, 'UTF-8');

        return $slug;
    }


    /////////////////////////////////////////////////////////

    //         Fonction de Cryptage et decryptage          //
    
    ////////////////////////////////////////////////////////


    function krypt($text) {
        $encrypted = '';
        $keyLength = strlen($this->key);

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $keyChar = $this->key[$i % $keyLength];
            $encryptedChar = chr(ord($char) + ord($keyChar));

            // Vérifier si le caractère résultant est "/"
            if ($encryptedChar === "/") {
                $encryptedChar = chr(ord($encryptedChar) + 1); // Décaler le caractère suivant
            }

            $encrypted .= $encryptedChar;
        }

        return base64_encode($encrypted);
    }

    function dekrypt($encryptedText) {
        $encryptedText = base64_decode($encryptedText);
        $decrypted = '';
        $keyLength = strlen($this->key);

        for ($i = 0; $i < strlen($encryptedText); $i++) {
            $char = $encryptedText[$i];
            $keyChar = $this->key[$i % $keyLength];
            
            // Vérifier si le caractère est le caractère décalé après "/"
            if ($char === "/") {
                $char = chr(ord($char) - 1); // Rétablir le caractère précédent
            }

            $decryptedChar = chr(ord($char) - ord($keyChar));
            $decrypted .= $decryptedChar;
        }

        return $decrypted;
    }


     /////////////////////////////////////////////////////////

    //             Fonction log                            //
    
    ////////////////////////////////////////////////////////


    function active_log($projet,$intervenant,$methode,$fonction, $url,$description) {


       /* $methode =  $request->method();
        $url = $request->fullUrl();
        $fonction = $request->route()->getActionMethod();
        $intervenant = auth()->User()->id;
        $projet=0;
        $description='';       
        dd($this->tools->active_log($projet,$intervenant,$methode,$fonction, $url,$description));*/

        $date = Carbon::now(); 
       
        $jour= $date->format('Y-m-d');
        $occurrence=1;

         $existe = DB::table('logs')
                ->where('projet_id', $projet)
                ->where('intervenant_id', $intervenant)
                ->where('url', $url)
                ->where('fonction', $fonction)
                ->where('jour', $jour)
                ->first();

        if(empty($existe->id_log)){

            $active_log = DB::table('logs')->insertGetId(
                [
                    'projet_id' => empty($projet) ? 0 : $this->controle_space($projet),
                    'intervenant_id' => $intervenant,
                    'methode' => $methode,
                    'fonction' => $fonction, 
                    'url' => $url, 
                    'occurrence' => $occurrence, 
                    'description' => empty($description) ? '' : $this->controle_space($description),
                    'jour' =>  $jour, 
                ]
            );
        }else{
           
           $occurrence = $existe->occurrence + 1 ;
            $active_log =  DB::table('logs')
                ->where('id_log', $existe->id_log)
                ->update(array(
                        'occurrence' => $occurrence, 
                        'updated_at' => $date,
                ));
        }
       
        return ($active_log );
    }


    /////////////////////////////////////////////////////////

    //             Fonction Transaction                          //
    
    ////////////////////////////////////////////////////////

    function transaction($idClient,$montant,$type,$mode,$description,$balance) {

       /* $idClient =  auth()->User()->id;
        $montant = $request->fullUrl();
        $type = $request->fullUrl();
        $mode = $request->route()->getActionMethod();
        $balance=0;
        $description='';       
        dd($this->tools->transaction($idClient,$montant,$type,$mode,$description,$balance)); */
      
        $transaction_id = DB::table('transactions')->insertGetId(
            [
                'amount' => $this->controle_space($montant),
                'transaction_type' => $this->controle_space($type),
                'transaction_mode' => $this->controle_space($mode),
                'intervenant_id' => $idClient, 
                'description' => empty($description) ? '' : $this->controle_space($description),
                'balance_after_transaction' => $balance,
            ]);
            return ($transaction_id);
    }


}
