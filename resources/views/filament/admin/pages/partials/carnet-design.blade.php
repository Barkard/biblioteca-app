<div style="width: 420px; height: 260px; border: 1px solid #222; border-radius: 2px; background: #fff; font-family: Arial, Helvetica, sans-serif; overflow: hidden;">
    <table style="width: 100%; height: 100%; border-collapse: collapse; border-spacing: 0;">
        <tr>
            <td style="width: 70%; vertical-align: top; padding: 10px 0 0 8px;">
                <!-- Logo y título -->
                <table style="width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 10px;">
                    <tr>
                        <td style="width: 50px; vertical-align: top;">
                            <img src="/images/logo_biblioteca.png" alt="Logo" style="height: 45px; display: block;">
                        </td>
                        <td style="vertical-align: middle; padding-left: 10px;">
                            <div style="font-size: 10px; font-weight: bold; line-height: 1.2; color: #000;">
                                RED DE BIBLIOTECAS PÚBLICAS<br>
                                ESTADO TÁCHIRA
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Biblioteca -->
                <div style="font-size: 9px; margin-bottom: 12px; line-height: 1.3; color: #000;">
                    <div style="font-weight: bold; color: #000;">BIBLIOTECA PÚBLICA:</div>
                    <div style="color: #000;">BIBLIOTECA PÚBLICA CENTRAL SAN CRISTÓBAL</div>
                </div>

                <!-- Datos del usuario -->
                <table style="width: 100%; border-collapse: collapse; border-spacing: 0; font-size: 10px; color: #000;">
                    <tr>
                        <td colspan="2" style="padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">APELLIDOS:</span>
                            <span style="margin-left: 20px; color: #000;">{{ strtoupper($user->last_name ?? 'PRUEBA') }} {{ strtoupper($user->second_last_name ?? 'APELLIDO') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">NOMBRES:</span>
                            <span style="margin-left: 20px; color: #000;">{{ strtoupper($user->name ?? 'NOMBRE') }} {{ strtoupper($user->second_name ?? 'SEGUNDO') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%; padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">CARNET No.:</span>
                            <span style="margin-left: 10px; color: #000;">{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td style="width: 50%; padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">C.I.:</span>
                            <span style="margin-left: 20px; color: #000;">{{ $user->nationality ?? 'V' }}-{{ $user->id_user ?? '0000000' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">EXPEDICIÓN:</span>
                            @php
                                $expeditionDate = $user->expedition ? \Carbon\Carbon::parse($user->expedition) : now();
                            @endphp
                            <span style="margin-left: 10px; color: #000;">{{ $expeditionDate->format('d/m/Y') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px 0; color: #000;">
                            <span style="font-weight: bold; color: #000;">VENCIMIENTO:</span>
                            <span style="margin-left: 10px; color: #000;">{{ $expeditionDate->addYears(2)->format('d/m/Y') }}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%; vertical-align: top; padding: 10px 10px 0 0; text-align: center;">
                <div style="width: 105px; height: 130px; border: 1px solid #222; background: #eee; margin: 0 auto; line-height: 130px; text-align: center;">
                    <span style="color: #888; font-size: 14px; vertical-align: middle;">FOTO</span>
                </div>
            </td>
        </tr>
    </table>
</div>