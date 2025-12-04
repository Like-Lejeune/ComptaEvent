<html>
<head>
    <meta charset="UTF-8">
    <title>ETAT GLOBAL DES SERVICES</title>

    <style>
        @page {
            margin: 130px 25px 110px 25px; /* top - right - bottom - left */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        /* === HEADER === */
        .header {
            position: fixed;
            top: -110px;
            left: 0;
            right: 0;
            height: 100px;
            border-bottom: 1px solid #000;
        }

        .header-table td {
            vertical-align: middle;
        }

        /* === FOOTER === */
        .footer {
            position: fixed;
            bottom: -90px;
            left: 0;
            right: 0;
            height: 80px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #000;
        }

        .footer .page-number:before {
            content: counter(page);
        }

        /* === TABLE GLOBAL === */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            border: 1px solid #000;
            background: #f5f5f5;
            padding: 6px;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .blue { color: #0033cc; font-weight: bold; }
        .red { color: red; font-weight: bold; }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .section-title {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <!-- === HEADER === -->
    <div class="header">
        <table class="header-table" width="100%">
            <tr>
                <td width="20%" align="left">
                    <img src="{{ public_path('control/images/nft/mtwlogo_dark.png') }}" width="170">
                </td>

                <td width="80%" align="center">
                    <div class="title">ETAT GLOBAL DES SERVICES</div>
                    <small>Imprimé le : <b>{{ now()->format('d/m/Y H:i') }}</b></small>
                </td>
            </tr>
        </table>
    </div>

    <!-- === FOOTER === -->
    <div class="footer">
        Imprimé par :<b>{{ auth()->user()->name }}</b> — Page <span class="page-number"></span>
    </div>

    <!-- ===== CONTENU PRINCIPAL ===== -->

    <table>
        <tr>
            <td><b>Projet: </b></td>
            <td class="blue"></td>
            <td class="blue"></td>
        </tr>
        <tr>
            <td><b>Budget Global</b></td>
            <td class="blue">{{ number_format($budget, 0, ',', ' ') }} XAF</td>
        </tr>
        <tr>
            <td><b>Dépenses Globales</b></td>
            <td class="blue">{{ number_format($sum_depense, 0, ',', ' ') }} XAF</td>
        </tr>
        <tr>
            <td><b>Solde Global</b></td>
            <td class="{{ $solde < 0 ? 'red' : 'blue' }}">
                {{ number_format(abs($solde), 0, ',', ' ') }} XAF
            </td>
        </tr>
        <tr>
            <td><b>Taux de Consommation</b></td>
            <td class="{{ $conso > 100 ? 'red' : 'blue' }}">
                {{ number_format($conso, 2) }} %
            </td>
        </tr>
    </table>

    <div class="section-title">TOTAL DES SERVICES : {{ $countService }}</div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Service</th>
                <th>Budget</th>
                <th>Dépenses</th>
                <th>Solde Actuel</th>
                <th>% Consommation</th>
            </tr>
        </thead>
        <tbody>

            @php $i = 1; @endphp
            @foreach($service as $svc)
                @php
                    $sumdep = DB::table('depense')
                        ->where('service_id', $svc->id_service)
                        ->sum('s_depense');

                    $conso = $svc->s_budget > 0
                        ? ($sumdep * 100 / $svc->s_budget)
                        : 0;
                @endphp

                <tr>
                    <td align="center">{{ $i++ }}</td>
                    <td>{{ $svc->s_name }}</td>
                    <td><b>{{ number_format($svc->s_budget, 0, ',', ' ') }} XAF</b></td>
                    <td><b>{{ number_format($sumdep, 0, ',', ' ') }} XAF</b></td>

                    <td align="center" class="{{ $svc->s_solde < 0 ? 'red' : 'blue' }}">
                        {{ number_format(abs($svc->s_solde), 0, ',', ' ') }} XAF
                    </td>

                    <td align="center" class="{{ $conso > 100 ? 'red' : 'blue' }}">
                        {{ number_format($conso, 2) }} %
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

</body>
</html>

