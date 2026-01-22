<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Carnet {{ $user->id_user }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: letter portrait;
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .container {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .carnet-wrapper {
            /* Center perfectly using absolute positioning for Letter size (215.9mm x 279.4mm) */
            position: absolute;
            top: 112.7mm; /* (279.4 - 54) / 2 */
            left: 65.15mm; /* (215.9 - 85.6) / 2 */
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #000;
            background-color: #fff;
            overflow: hidden;
        }
        .header {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            height: 10mm; /* Reduced slightly to match preview proportion */
            line-height: 10mm;
            width: 100%;
        }
        .header-text {
            font-size: 7pt;
            font-weight: bold;
            line-height: normal; /* Reset line height for multi-line text */
            display: inline-block;
            vertical-align: middle;
            padding-top: 1mm;
        }
        
        /* Main Layout Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 1mm;
        }
        .col-left {
            width: 65%;
            vertical-align: top;
            padding: 2mm 2mm 2mm 4mm;
        }
        .col-right {
            width: 35%;
            vertical-align: middle;
            text-align: center;
            padding: 2mm;
        }

        /* Typography matching preview */
        .label {
            font-size: 5pt;
            color: #555;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.5pt;
        }
        .value {
            font-size: 8pt;
            font-weight: bold;
            color: #000;
            margin-bottom: 3pt;
            display: block;
            text-transform: uppercase;
            line-height: 1.1;
        }
        
        .photo-box {
            width: 21mm; /* 85px approx */
            height: 27mm; /* 110px approx */
            border: 1px solid #ddd;
            background-color: #f8f8f8;
            margin: 0 auto;
            text-align: center;
            line-height: 27mm;
        }
        .photo-text {
            color: #ccc;
            font-size: 6pt;
            vertical-align: middle;
            display: inline-block;
            line-height: normal;
        }

        /* Footer Dates Table */
        .dates-table {
            width: 100%;
            border-top: 1px solid #eee;
            margin-top: 2mm;
            padding-top: 1mm;
            border-collapse: collapse;
        }
        .date-cell {
            width: 50%;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="carnet-wrapper">
            <!-- Header -->
            <div class="header">
                <div class="header-text">
                    INSTITUCIÓN EDUCATIVA<br>
                    "DR. LEONARDO RUIZ PINEDA"
                </div>
            </div>

            <!-- Content -->
            <table class="content-table">
                <tr>
                    <td class="col-left">
                        <div style="margin-bottom: 2pt;">
                            <div class="label">NOMBRE COMPLETO</div>
                            <div class="value">
                                {{ strtoupper($user->name) }} {{ strtoupper($user->second_name) }}<br>
                                {{ strtoupper($user->last_name) }} {{ strtoupper($user->second_last_name) }}
                            </div>
                        </div>

                        <div style="margin-bottom: 2pt;">
                            <div class="label">CÉDULA DE IDENTIDAD</div>
                            <div class="value">{{ $user->nationality }}-{{ number_format($user->id_user, 0, '.', '.') }}</div>
                        </div>

                        <div style="margin-bottom: 2pt;">
                            <div class="label">ROL / CARGO</div>
                            <div class="value">{{ strtoupper($user->role->name ?? 'USUARIO') }}</div>
                        </div>

                        <!-- Dates -->
                        <table class="dates-table">
                            <tr>
                                <td class="date-cell">
                                    <div class="label" style="color: #777;">EXPEDICION</div>
                                    <div class="value" style="font-size: 7pt;">{{ now()->format('d/m/Y') }}</div>
                                </td>
                                <td class="date-cell">
                                    <div class="label" style="color: #777;">VENCIMIENTO</div>
                                    <div class="value" style="font-size: 7pt;">{{ now()->addMonths(6)->format('d/m/Y') }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="col-right">
                        <div class="photo-box">
                            <span class="photo-text">FOTO</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
