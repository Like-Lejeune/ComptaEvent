<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Etat PDF - {{ $info->s_name }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            position: relative;
        }

        /* FILIGRANE */
        .watermark {
            position: fixed;
            top: 30%;
            left: 20%;
            opacity: 0.1;
            width: 500px;
            z-index: - 1;
        }

        header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #003366;
            padding-bottom: 10px;
        }

        header img.logo {
            width: 130px;
            margin-bottom: 5px;
        }

        h2.title {
            font-size: 22px;
            margin: 5px 0;
            color: #003366;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table th {
            background: #003366;
            color: white;
            border: 1px solid #333;
            padding: 6px;
            font-size: 13px;
            font-weight: bold;
        }

        table td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 12px;
        }

        footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .section-title {
            margin-top: 25px;
            font-size: 16px;
            font-weight: bold;
            color: #003366;
            text-transform: uppercase;
        }

        /* Tableau récap */
        .recap-table th {
            background: #f2f2f2;
            color: #000;
        }

        /* Graph */
        .chart {
            margin-top: 20px;
            text-align: center;
        }
        .header-table, 
        .header-table tr, 
        .header-table td {
            border: none !important;
        }

        .header-table {
            border-collapse: collapse !important;
        }
    </style>
</head>

<body>

{{-- <!-- FILIGRANE -->
<img src="{{ public_path('control/images/nft/mtwlogo_dark.png') }}" class="watermark"> --}}

<header>
    <div class="header">
        <table class="header-table" width="100%">
            <tr>
                <td width="30%" align="center">
                    <img src="{{ public_path('control/images/nft/mtwlogo_dark.png') }}" width="120">
                </td>

                <td width="40%" align="center">
                    <div class="title"><b style="font-size: 15px">ÉTAT DES DÉPENSES</b></div>
                    <small>Imprimé le : <b>{{ now()->format('d/m/Y H:i') }}</b></small>
                </td>
                 <td width="30%" align="center">
                   <div><strong>Service :</strong> {{ $info->s_name }}</div>
                </td>
            </tr>
        </table>
    </div>
</header>
<div class="section-title">Détails des opérations ({{ $countService }})</div>

<table>
    <thead>
        <tr>
            <th>N°</th>
            <th>Désignation</th>
            <th>Dépense</th>
            <th>Description</th>
            <th>Pieces jointes</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @php $i = 1; @endphp
        @foreach($depense as $d)
            <tr>
                <td style="text-align:center">{{ $i++ }}</td>
                <td>{{ $d->d_name }}</td>
                <td><strong>{{ number_format($d->s_depense, 0, ',', ' ') }} XAF</strong></td>
                <td><small>{{ $d->d_description }}</small></td>
                <td style="text-align:center"><strong>{{ $d->nb_piece }}</strong></td>
                <td>{{ $d->date_operation }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- TABLEAU RECAPITULATIF -->
<div class="section-title">Récapitulatif</div>
<table class="recap-table">
    <tr>
        <th>Budget Total</th>
        <td>{{ number_format($budget, 0, ',', ' ') }} XAF</td>
    </tr>
    <tr>
        <th>Dépenses Totales</th>
        <td>{{ number_format($sum_depense, 0, ',', ' ') }} XAF</td>
    </tr>
    <tr>
        <th>Solde</th>
        <td>{{ number_format($solde, 0, ',', ' ') }} XAF</td>
    </tr>
    <tr>
        <th>% Consommation</th>
        <td>{{ number_format($conso, 2) }} %</td>
    </tr>
</table>

<!-- GRAPHIQUE -->
<div class="chart">
    <img src="{{ $chartBase64 }}" width="480">
</div>

<footer>
    Imprimé par {{ auth()->user()->name }} – {{ $date_courante }}  
    <br> 
</footer>


</body>
</html>
