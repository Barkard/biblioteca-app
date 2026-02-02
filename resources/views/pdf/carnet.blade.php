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
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            background: #fff;
        }
        .container {
            width: 100%;
            padding: 15mm 0; /* Padding for the entire letter page */
        }
        .carnet-wrapper {
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #222;
            background-color: #fff;
            overflow: hidden;
            margin: 0 auto 10mm auto; /* Spacing between front and back */
            position: relative;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            // Convert logo to base64 for PDF
            $logoPath = public_path('images/logo_biblioteca.png');
            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
            $logoSrc = $logoData ? 'data:image/png;base64,' . $logoData : '';
            $expeditionDate = $user->expedition ? \Carbon\Carbon::parse($user->expedition) : now();
        @endphp
        
        <!-- PARTE DELANTERA -->
        <div class="carnet-wrapper">
            <table style="width: 100%; height: 100%; border-collapse: collapse; border-spacing: 0;">
                <tr>
                    <td style="width: 70%; vertical-align: top; padding: 2.1mm 0 0 1.7mm;">
                        <!-- Logo y título -->
                        <table style="width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 2.1mm;">
                            <tr>
                                <td style="width: 10.4mm; vertical-align: top;">
                                    @if($logoSrc)
                                        <img src="{{ $logoSrc }}" alt="Logo" style="height: 8.5mm; display: block;">
                                    @endif
                                </td>
                                <td style="vertical-align: middle; padding-left: 2.1mm;">
                                    <div style="font-size: 7.2pt; font-weight: bold; line-height: 1.1; color: #000;">
                                        RED DE BIBLIOTECAS PÚBLICAS<br>
                                        ESTADO TÁCHIRA
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- Biblioteca -->
                        <div style="font-size: 6.2pt; margin-bottom: 2.5mm; line-height: 1.2; color: #000;">
                            <div style="font-weight: bold; color: #000;">BIBLIOTECA PÚBLICA:</div>
                            <div style="color: #000;">BIBLIOTECA PÚBLICA CENTRAL SAN CRISTÓBAL</div>
                        </div>

                        <!-- Datos del usuario -->
                        <table style="width: 100%; border-collapse: collapse; border-spacing: 0; font-size: 7pt; color: #000;">
                            <tr>
                                <td colspan="2" style="padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">APELLIDOS:</span>
                                    <span style="margin-left: 4.2mm; color: #000;">{{ strtoupper($user->last_name ?? 'PRUEBA') }} {{ strtoupper($user->second_last_name ?? 'APELLIDO') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">NOMBRES:</span>
                                    <span style="margin-left: 4.2mm; color: #000;">{{ strtoupper($user->name ?? 'NOMBRE') }} {{ strtoupper($user->second_name ?? 'SEGUNDO') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">CARNET No.:</span>
                                    <span style="margin-left: 2.1mm; color: #000;">{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td style="width: 50%; padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">C.I.:</span>
                                    <span style="margin-left: 4.2mm; color: #000;">{{ $user->nationality ?? 'V' }}-{{ $user->id_user ?? '0000000' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">EXPEDICIÓN:</span>
                                    <span style="margin-left: 2.1mm; color: #000;">{{ $expeditionDate->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 0.6mm 0; color: #000;">
                                    <span style="font-weight: bold; color: #000;">VENCIMIENTO:</span>
                                    <span style="margin-left: 2.1mm; color: #000;">{{ $expeditionDate->addYears(2)->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 30%; vertical-align: top; padding: 2.1mm 2.1mm 0 0; text-align: center;">
                        <div style="width: 21.4mm; height: 27.1mm; border: 1px solid #222; background: #eee; margin: 0 auto; line-height: 27.1mm; text-align: center;">
                            <span style="color: #888; font-size: 10pt; vertical-align: middle;">FOTO</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- PARTE TRASERA -->
        <div class="carnet-wrapper" style="padding: 1.7mm; box-sizing: border-box;">
            <div style="text-align:center; font-size:6.3pt; font-weight:bold; margin-bottom:1mm; color:#000;">
                RED DE BIBLIOTECAS PÚBLICAS<br>
                ESTADO TÁCHIRA
            </div>
            <div style="font-size:5.2pt; color:#000; line-height:1.2; text-align:justify;">
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
</body>
</html>
