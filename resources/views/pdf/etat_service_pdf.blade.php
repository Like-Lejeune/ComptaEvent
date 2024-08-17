
                                  
                     
                            
                                                    
<html>
    <head>
        <title>ETAT PDF: {{$info->s_name}} </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="#">
        <style type="text/css">
            table{
                margin: auto;
            }
            *{
                font-size: 14px;
                font-family: arial, sans-serif;
            }
            .tr-td td{
                border-right: 1px solid #000;
                padding: 5px;
                font-family: Arial;
            }
            .tr-top td{
                border: 1px solid #000;
                padding: 5px;
                font-family: Arial;
            }
            .tr-th span{
                font-size: 12px!important;
            }
            .tr-th th{
                padding: 5px;
            }
            .titre{
                font-size: 26px;
            }.titre2{
                 font-size: 18px;
             }
            .footer td{
                padding: 10px;
            }
            .content td{
                padding: 5px;
            }
            small,.small{
                font-size: 12px;
            }
            .header{    
                background: lightgray;
            }
            
    
            .bold{
                font-weight: bold;
            }
            .content{
                border-collapse: collapse;
                width:100%;
            }
            .content td{
                border-collapse: collapse;
    
                border: 1px solid #6b6d6e;
            }
            .content th{
                 border-collapse: collapse;
    
                 border: 1px solid #6b6d6e;
             }
            .col-pk-2{
                width: 20%;
            }
            .col-pk-4{
                width: 40%;
            }
            .col-pk-10{
                width: 100%;
            }
            .text-left{
                text-align: left;
            }
            .bg{
                position: absolute;
                width: 500px;
                bottom: 10%;
                height: auto;
    
            }
            .fixed{
                position: fixed;
                width: 100px;
                bottom: 0;
              
    
            }
           
        </style>
    </head>
    <body>
        <h4 class="card-title mb-0 flex-grow-1">STATISTIQUES</h4>
                       
        @php
             $countService = DB::table('depense')
             ->where('service_id', '=', $service->service_id)
             ->count();
    
         $budget = DB::table('services')
         ->where('id_service', '=', $service->service_id)
         ->sum('s_budget');
       
         $sum_depense = DB::table('depense')
         ->where('service_id', '=', $service->service_id)
         ->sum('s_depense');
        
             $solde = DB::table('services')
                ->where('id_service', '=', $service->service_id)
                ->sum('s_solde');
    
            $depense = DB::table('depense')
                ->where('service_id', '=', $service->service_id)
                ->get();


            $sumdep = DB::table('depense')
                ->where('service_id', '=', $service->service_id)
                ->sum('s_depense');
            $conso=($sum_depense*100)/$budget;

            $pos= 0;
        @endphp
    
    <table border="2" style="width: 100%; border-collapse: collapse; border: 1px solid black;font-family: Comic Sans MS; ">
           
            <tr >
                <td colspan="8" align="center" style="border: 1PX solid black; font-family: Comic Sans MS;padding: 5px;border-right: 2px solid black"><strong>ETAT DES DEPENSES</strong> </td>
            </tr>
            <tr >
                <td colspan="4" align="left" style="border: 1PX solid black; font-family: Comic Sans MS;padding: 5px;border-right: 2px solid rgb(27, 20, 20)">SERVICE</td>
                <td colspan="4" align="center" style="border: 1PX solid black; font-family: Comic Sans MS;padding: 5px;border-right: 2px solid rgb(63, 6, 6)"><strong>{{$info->s_name}}</strong> </td>
            </tr>
            <tr style="border-bottom: 1px solid #000">
                <td colspan="4" align="left" style="font-family: Comic Sans MS;padding: 5px;  font-size: 15px; ">Imprimé le : <i><b style="font-size: 12px; ">{{$date_courante}}</b></i>    </td>
                <td colspan="4" align="Center" style="font-family: Comic Sans MS;padding: 5px;">Par: {{auth()->User()->name}} </td>
            </tr>
            <tr>
                <td colspan="4" align="left" style="font-family: Comic Sans MS;padding: 5px;">BUDGET TOTAL : <strong> </strong></td>
                <td colspan="4" align="center" style="font-family: Comic Sans MS;padding: 5px;">  <strong> {{number_format($budget, 0, ',', ' ')}} XAF </strong>  </td>
                
            </tr>
            <tr>
                <td colspan="4" align="left" style="font-family: Comic Sans MS;padding: 5px;">DEPENSES TOTALES: </td>
                <td colspan="4" align="center" style="font-family: Comic Sans MS;padding: 5px;"><strong>{{number_format($sum_depense, 0, ',', ' ')}} XAF </strong></td>
                {{-- <td colspan="1" align="center" style="font-family: Comic Sans MS;padding: 5px;"> CREDIT: <strong> </strong> </td>
                <td colspan="2" align="center" style="font-family: Comic Sans MS;padding: 5px;"> TYPE: <strong> </strong></td> --}}
            </tr>
            <tr style="border-bottom: 3px solid #000">
                <td colspan="4" align="left" style="font-family: Comic Sans MS;padding: 5px;border-bottom: 3px solid #000">
                     @if ($solde < 0)
                    <b style="color: red;">Dépassement du Budget de : {{number_format(abs( $solde), 0, ',', ' ')}} XAF  </b>
                    @else
                    <b style="color: rgb(38, 0, 255);">Solde Réel : {{number_format(abs( $solde), 0, ',', ' ')}} XAF</b>
                    @endif</td>
                <td colspan="4" style="font-family: Comic Sans MS;padding: 5px; font-size:16px; border-bottom: 3px solid #000"> % consommation du Budget :  
                    @if ($conso > 100)
                    <b style="color: red;"> {{number_format($conso, 2)}} %</b>
                    @else
                    <b style="color: rgb(38, 0, 255);"> {{number_format($conso, 2)}} %</b>
                    @endif</td>
                </p> </td>
            </tr>
            
            
           
        </table><br>
        <h4 class="card-title mb-0 flex-grow-1">TOTAL DES OPERATIONS :   {{$countService}}</h4>
    
    <table style="border-collapse: collapse;" width="100%">

        <tr  class=" tr-th">
            <th style="border: 1px solid #000; text-align: center; ; ">N°</th>
            <th style="border: 1px solid #000; text-align: left; ; ">Désignation</th>
            <th style="border: 1px solid #000; text-align: left; ; ">Depense</th>
            <th style="border: 1px solid #000; text-align: left; ; ">description</th>
            <th style="border: 1px solid #000; text-align: left; ; ">pièce jointe</th>
            <th style="border: 1px solid #000; text-align: left; ; ">date opération</th>
        </tr>
    <tbody style="border: 1px solid #000;">
        @forelse ( $depense as $depense)
        @php
            $pos++
        @endphp
        <tr class="tr-td" style="border: 1px solid #000;">
            <td style="border: 1px solid #000; text-align: center; ">{{$pos}}</td>
            <td style="border: 1px solid #000; text-align: left; ">{{ html_entity_decode($depense->d_name) }}</td>
            <td style="border: 1px solid #000; text-align: left; "> <b>{{number_format($depense->s_depense, 0, ',', ' ')}}  XAF</b>
            </td>
            <td style="border: 1px solid #000; text-align: left; "><small>{{ html_entity_decode($depense->d_description) }}</small>
            </td>
            @php
                 $nb_piece = DB::table('piece_jointe')
                ->where('depense_id','=',$depense->id_depense)
                ->count();
            @endphp
              <td style="border: 1px solid #000; text-align: center; "><strong>{{$nb_piece}}</strong> </td>
            <td style="border: 1px solid #000; text-align: left; "><small class="badge badge-soft-primary">
                    {{ $depense->date_operation }}</small> </td>
        </tr>
    @empty
        <tr>
            <td style="border: 1px solid #000; text-align: center; " colspan="5">
                <b>{{ __('Aucune donnée disponible') }}</b></td>
        </tr>
    @endforelse
    
    </tbody>
    
    
    </table><br>
     
    </body>
    </html>