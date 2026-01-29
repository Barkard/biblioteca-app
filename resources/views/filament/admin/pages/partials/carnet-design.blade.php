<div style="width: 342px; height: 216px; border: 1px solid #ccc; border-radius: 8px; overflow: hidden; position: relative; background-color: #fff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); font-family: sans-serif;">
    <!-- Header -->
    <div style="background-color: #1e3a8a; color: white; padding: 5px; text-align: center; height: 40px; display: flex; align-items: center; justify-content: center; line-height: 1.2;">
        <div style="font-size: 10px; font-weight: bold;">
            INSTITUCIÓN EDUCATIVA<br>
            "DR. LEONARDO RUIZ PINEDA"
        </div>
    </div>
    
    <div style="display: flex; height: 176px;">
        <!-- Left Info -->
        <div style="width: 65%; padding: 12px; font-size: 10px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="margin-bottom: 6px;">
                    <span style="font-weight: bold; color: #555; font-size: 8px;">NOMBRE COMPLETO</span><br>
                    <span style="font-weight: bold; font-size: 11px; color: #000;">
                        {{ strtoupper($user->name) }} {{ strtoupper($user->second_name) }}<br>
                        {{ strtoupper($user->last_name) }} {{ strtoupper($user->second_last_name) }}
                    </span>
                </div>
                <div style="margin-bottom: 6px;">
                    <span style="font-weight: bold; color: #555; font-size: 8px;">CÉDULA DE IDENTIDAD</span><br>
                    <span style="font-weight: bold; font-size: 11px; color: #000;">{{ $user->nationality }}-{{ $user->id_user }}</span>
                </div>
                <div style="margin-bottom: 6px;">
                    <span style="font-weight: bold; color: #555; font-size: 8px;">ROL</span><br>
                    <span style="font-weight: bold; font-size: 11px; color: #000;">{{ strtoupper($user->role->name ?? '') }}</span>
                </div>
            </div>
            
            <div style="font-size: 8px; color: #333; margin-top: 5px; border-top: 1px solid #eee; padding-top: 5px; display: flex; justify-content: space-between;">
                 <div>
                    <span style="color: #777;">EXPEDICION</span><br>
                    <strong>{{ now()->format('d/m/Y') }}</strong>
                 </div>
                 <div>
                    <span style="color: #777;">VENCIMIENTO</span><br>
                    <strong>{{ now()->addMonths(6)->format('d/m/Y') }}</strong>
                 </div>
            </div>
        </div>
        
        <!-- Right Photo -->
        <div style="width: 35%; display: flex; align-items: center; justify-content: center; padding: 10px;">
            <div style="width: 85px; height: 110px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; background-color: #f8f8f8;">
                <span style="color: #ccc; font-size: 9px; text-align: center;">FOTO</span>
            </div>
        </div>
    </div>
</div>