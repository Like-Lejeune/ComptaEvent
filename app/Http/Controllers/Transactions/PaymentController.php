<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Tools;


class PaymentController extends Controller
{
    //

    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function addCredit()
    {
        return view('client.transaction.buyCredit');
    }
    public function historique_transaction()
    {
        return view('client.transaction.historique');
    }
    public function AddCreditAdmin($Idclient)
    {
        return view('admin.AddCreditAdmin')->with('Idclient', $Idclient);;
    }

    public function SubmitCreditAdmin(Request $request)
    {
        // Logique métier

        $validator = Validator::make($request->all(), [

            'amount' => 'required|max:200',
            'IDuser' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Montant inexistant'
            ]);
        } else {
            $Wallet = DB::table('users')->where('id', $request->input('IDuser'))->value('wallet');
            $wallet = $Wallet + $request->input('amount');
            DB::table('users')
                ->where('id', $request->input('IDuser'))
                ->update(array(
                    'wallet' => $wallet,
                ));



            // Enregistrement de l'activité 

            $methode =  $request->method();
            $url = $request->fullUrl();
            $fonction = $request->route()->getActionMethod();
            $intervenant = auth()->User()->id;
            $projet = 0;
            $description = '';
            $this->tools->active_log($projet, $intervenant, $methode, $fonction, $url, $description);

            // En registrement de la transaction

            $idClient =  $request->input('IDuser');
            $montant = $request->input('amount');
            $type = 'credit';
            $mode = 'compteMTW';
            $balance = $wallet;
            $description = 'recharge compteMTW  par un Administrateur';
            $this->tools->transaction($idClient, $montant, $type, $mode, $description, $balance);


            return redirect()->back()->with('success', 'Credit added successfully');
        }
    }


    public function paiementCompteMytaskwork(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'wallet_mtw' => 'required|max:200',
            'work_id' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Montant inexistant'
            ]);
        } else {
            $Wallet = DB::table('users')->where('id', auth()->User()->id)->value('wallet');
            $wallet = $Wallet - $request->input('wallet_mtw');

            DB::table('works')
                ->where('id_work', $request->input('work_id'))
                ->update(array(
                    'w_paid' => 'paid',
                ));
            DB::table('users')
                ->where('id', auth()->User()->id)
                ->update(array(
                    'wallet' => $wallet,
                ));

            $destinataire = DB::table('works')
                ->join('users', 'users.id', '=', 'user_id')
                ->where('id_work', $request->input('work_id'))
                ->first();

            // Enregistrement de l'activité 

            $methode =  $request->method();
            $url = $request->fullUrl();
            $fonction = $request->route()->getActionMethod();
            $intervenant = auth()->User()->id;
            $projet = $request->input('work_id');
            $description = '';
            $this->tools->active_log($projet, $intervenant, $methode, $fonction, $url, $description);

            // En registrement de la transaction

            $idClient =  auth()->User()->id;
            $montant = $request->input('amount');
            $type = 'debit';
            $mode = 'compteMTW';
            $balance = $wallet;
            $description = 'paiement du projet :' + $destinataire->titre_travail;
            $this->tools->transaction($idClient, $montant, $type, $mode, $description, $balance);

          return redirect()->back()->with('success', 'payment made successfully.');

        }
    }

    public function buyCredit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card' => 'required|max:200',
            'cvn' => 'required|max:200',
            'expiryMonth' => 'required|max:200',
            'expiryYear' => 'required|max:200',
            'amount' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'No value'
            ]);
        } else {
            $Wallet = DB::table('users')->where('id', auth()->User()->id)->value('wallet');
            $wallet = $Wallet + $request->input('amount');
            DB::table('users')
                ->where('id', auth()->User()->id)
                ->update(array(
                    'wallet' => $wallet,
                ));

             // Enregistrement de l'activité 

             $methode =  $request->method();
             $url = $request->fullUrl();
             $fonction = $request->route()->getActionMethod();
             $intervenant = auth()->User()->id;
             $projet = 0;
             $description = '';
             $this->tools->active_log($projet, $intervenant, $methode, $fonction, $url, $description);
 
             // Enregistrement de la transaction
 
             $idClient =  auth()->User()->id;
             $montant = $request->input('amount');
             $type = 'credit';
             $mode = 'compteMTW';
             $balance = $wallet;
             $description = 'paiement du crédit';
             $this->tools->transaction($idClient, $montant, $type, $mode, $description, $balance);

            return redirect()->back()->with('success', 'Credit added successfully.');
        }
    }

    public function DeleteProjet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_deleteProject' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'No value'
            ]);
        } else {
            ///  remboursement sur la plateforme compte virtuel
            if (auth()->User()->type == "super" || auth()->User()->type == "admin") {
                $valR = 0;
                $projet_image = DB::table('option_image')
                    ->join('options', 'options.option_id', '=', 'option_image.option_id')
                    ->select('*')
                    ->where('projet_id', '=', $request->input('id_deleteProject'))
                    ->where('etat', '=', 'choice')
                    ->get();
                foreach ($projet_image as  $projet_img) {

                    $valR = $valR + $projet_img->optn_price;
                }

                $usersID = DB::table('users')
                    ->join('projects', 'pjt_user', '=', 'users.id')
                    ->where('projects.id', '=', $request->input('id_deleteProject'))
                    ->value('users.id');
                $Wallet = DB::table('users')->where('id', $usersID)->value('wallet');
                $wallet = $Wallet + $valR;

                DB::table('users')
                    ->where('id', $usersID)
                    ->update(array(
                        'wallet' => $wallet,
                    ));
            }
            $Deteleoption_image = DB::table('option_image')
                ->where('projet_id', $request->input('id_deleteProject'))
                ->delete();
            $deleteImageProjet = DB::table('image_projet')
                ->where('projet_id', $request->input('id_deleteProject'))
                ->delete();
            $deleteProjet = DB::table('projects')
                ->where('id', $request->input('id_deleteProject'))
                ->delete();
            return redirect()->back()->with('success', 'Project deleted successfully.');
        }
    }
}
