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
        .page {
            width: 215.9mm;
            height: 279.4mm;
            position: relative;
            box-sizing: border-box;
        }

        .carnet-wrapper {
            /* card centered on the page */
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #222;
            background-color: #fff;
            overflow: hidden;
            margin: 0 auto;
            position: relative;
            top: calc((279.4mm - 54mm) / 2);
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
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
            <div class="page">
                <div class="carnet-wrapper" style="display: flex; flex-direction: row;">
                    <!-- Columna izquierda: logo y datos -->
                    <div style="width: 70%; padding: 6px 0 0 6px; display: flex; flex-direction: column; justify-content: flex-start;">
                        <div style="display: flex; align-items: flex-start; margin-bottom: 2px;">
                            <img src="/images/logo_biblioteca.png" alt="Logo" style="height: 12px; margin-right: 3px;">
                            <div style="font-size: 5pt; font-weight: bold; line-height: 1.1; margin-top: 1px;">
                                RED DE BIBLIOTECAS PÚBLICAS<br>
                                ESTADO TÁCHIRA
                            </div>
                        </div>
                        <div style="font-size: 4.5pt; margin-bottom: 2px; margin-top: 2px;">
                            <span style="font-weight: bold;">BIBLIOTECA PÚBLICA:</span>
                            <span style="margin-left: 1px;">BIBLIOTECA PÚBLICA CENTRAL SAN CRISTÓBAL</span>
                        </div>
                        <table style="width: 100%; font-size: 5.5pt; margin-top: 6px;">
                            <tr>
                                <td style="font-weight: bold; width: 32%;">APELLIDOS:</td>
                                <td style="width: 68%;">{{ strtoupper($user->last_name) }} {{ strtoupper($user->second_last_name) }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">NOMBRES:</td>
                                <td>{{ strtoupper($user->name) }} {{ strtoupper($user->second_name) }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">CARNET No.:</td>
                                <td>{{ $user->carnet_number ?? $user->id_user }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">C.I.:</td>
                                <td>{{ $user->nationality }}-{{ $user->id_user }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">EXPEDICIÓN:</td>
                                <td>{{ $user->expedition ?? now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">VENCIMIENTO:</td>
                                <td>{{ $user->expiration ?? now()->addYears(2)->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Columna derecha: foto -->
                    <div style="width: 30%; display: flex; align-items: flex-start; justify-content: center; padding: 6px 0 0 0;">
                        <div style="width: 32px; height: 40px; border: 1px solid #222; background: #eee; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #888; font-size: 5pt; text-align: center;">FOTO</span>
                        </div>
                    </div>
                </div>

            <!-- Page 2: Reverse -->
            <div class="page" style="page-break-before: always;">
                <div class="carnet-wrapper" style="padding: 8px 8px 8px 8px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: flex-start;">
                    <div style="text-align:center; font-size:6pt; font-weight:bold; margin-bottom:2px; color:#222;">
                        RED DE BIBLIOTECAS PÚBLICAS<br>
                        ESTADO TÁCHIRA
                    </div>
                    <div style="font-size:5pt; color:#222; line-height:1.1; text-align:justify;">
                        <span style="font-weight:bold;">- LA INSCRIPCIÓN EN EL SERVICIO DE PRÉSTAMO AL HOGAR ES VÁLIDA EN TODOS LOS SERVICIOS BIBLIOTECARIOS DE LA RED DE BIBLIOTECAS PÚBLICAS DEL ESTADO TÁCHIRA.</span>
                        <br><br>
                        <span style="font-weight:bold;">- EL PRÉSTAMO AL HOGAR SE HARÁ DIRECTA Y SOLO AL USUARIO CARNETIZADO. EL CARNET ES DE USO INDIVIDUAL E INTRANSFERIBLE Y DEBE SER ACTUALIZADO CADA DOS (02) AÑOS.</span>
                        <br><br>
                        <span style="font-weight:bold;">- AL FIRMAR LA PLANILLA DE SOLICITUD EL USUARIO ACEPTA LAS CONDICIONES ESTABLECIDAS, ASÍ COMO EL PAGO POR DÍAS DE ATRASO EN LA ENTREGA DEL MATERIAL BIBLIOGRÁFICO CEDIDO EN CALIDAD DE PRÉSTAMO.</span>
                        <br><br>
                        <span style="font-weight:bold;">- EN LOS PRÉSTAMOS VENCIDOS SE SUSPENDERÁ EL DERECHO AL SERVICIO Y SE RETENDRÁ EL CARNET POR UN PERÍODO EQUIVALENTE A TRES (03) DÍAS CONTINUOS POR CADA DÍA DE MOROSIDAD.</span>
                        <br><br>
                        <span style="font-weight:bold;">- EN CASO DE EXTRAVÍO DEL CARNET, EL USUARIO DEBERÁ COMUNICARLO DE INMEDIATO AL SERVICIO DE PRÉSTAMO AL HOGAR.</span>
                        <br><br>
                        <span style="font-weight:bold;">- EL RETARDO POR LA ENTREGA DE LIBROS CEDIDOS COMO PRÉSTAMO AL HOGAR SE ACUMULARÁ HASTA UN MÁXIMO DE TRES FALTAS (03) LO QUE ACARRIARÁ LA SUSPENSIÓN DEFINITIVA DEL BENEFICIO DEL PRÉSTAMO.</span>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>
