<div style="width: 420px; height: 260px; border: 1px solid #222; border-radius: 2px; background: #fff; font-family: Arial, Helvetica, sans-serif; display: flex; flex-direction: row; overflow: hidden;">
    <!-- Columna izquierda: logo y datos -->
    <div style="width: 70%; padding: 16px 0 0 16px; display: flex; flex-direction: column; justify-content: flex-start;">
        <div style="display: flex; align-items: flex-start; margin-bottom: 2px;">
            <img src="/images/logo_biblioteca.png" alt="Logo" style="height: 32px; margin-right: 8px;">
            <div style="font-size: 10px; font-weight: bold; line-height: 1.1; margin-top: 2px;">
                RED DE BIBLIOTECAS PÚBLICAS<br>
                ESTADO TÁCHIRA
            </div>
        </div>
        <div style="font-size: 9px; margin-bottom: 2px; margin-top: 2px;">
            <span style="font-weight: bold;">BIBLIOTECA PÚBLICA:</span>
            <span style="margin-left: 2px;">BIBLIOTECA PÚBLICA CENTRAL SAN CRISTÓBAL</span>
        </div>
        <table style="width: 100%; font-size: 10px; margin-top: 12px;">
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
    <div style="width: 30%; display: flex; align-items: flex-start; justify-content: center; padding: 16px 0 0 0;">
        <div style="width: 90px; height: 110px; border: 1px solid #222; background: #eee; display: flex; align-items: center; justify-content: center;">
            <span style="color: #888; font-size: 12px; text-align: center;">FOTO</span>
        </div>
    </div>
</div>