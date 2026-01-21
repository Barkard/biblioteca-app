@php
    $totalMinors = $counts['0-11']['male'] + $counts['0-11']['female'] + $counts['12-18']['male'] + $counts['12-18']['female'];
    $totalAdults = $counts['19-24']['male'] + $counts['19-24']['female'] + $counts['25+']['male'] + $counts['25+']['female'];
    $grandTotal = $totalMinors + $totalAdults;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">10.- VISITAS DE USUARIOS</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 18px;">{{ $grandTotal }}</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">Reporte del {{ $dateFrom }} al {{ $dateTo }}</th>
        </tr>
        

        <!-- Totales Por Genero y Rango (Debajo de los totales de edad) -->
         <tr>
             <!-- 0-11 -->
            <th style="text-align: center; font-weight: bold;">{{ $counts['0-11']['male'] }}</th>
            <th style="text-align: center; font-weight: bold;">{{ $counts['0-11']['female'] }}</th>
             <!-- 12-18 -->
            <th style="text-align: center; font-weight: bold;">{{ $counts['12-18']['male'] }}</th>
            <th style="text-align: center; font-weight: bold;">{{ $counts['12-18']['female'] }}</th>
             <!-- 19-24 -->
            <th style="text-align: center; font-weight: bold;">{{ $counts['19-24']['male'] }}</th>
            <th style="text-align: center; font-weight: bold;">{{ $counts['19-24']['female'] }}</th>
             <!-- 25+ -->
            <th style="text-align: center; font-weight: bold;">{{ $counts['25+']['male'] }}</th>
            <th style="text-align: center; font-weight: bold;">{{ $counts['25+']['female'] }}</th>
        </tr>

        <tr>
            <th colspan="4" style="text-align: center; font-weight: bold;">Menores</th>
            <th colspan="4" style="text-align: center; font-weight: bold;">Adultos</th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center;">0 - 11</th>
            <th colspan="2" style="text-align: center;">12 - 18</th>
            <th colspan="2" style="text-align: center;">19 - 24</th>
            <th colspan="2" style="text-align: center;">25 - más</th>
        </tr>
        <tr>
            <th style="text-align: center; width: 100px;">H</th>
            <th style="text-align: center; width: 100px;">M</th>
            <th style="text-align: center; width: 100px;">H</th>
            <th style="text-align: center; width: 100px;">M</th>
            <th style="text-align: center; width: 100px;">H</th>
            <th style="text-align: center; width: 100px;">M</th>
            <th style="text-align: center; width: 100px;">H</th>
            <th style="text-align: center; width: 100px;">M</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td style="text-align: center;">{{ ($log->age >= 0 && $log->age <= 11 && $log->gender === 'male') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 0 && $log->age <= 11 && $log->gender === 'female') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 12 && $log->age <= 18 && $log->gender === 'male') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 12 && $log->age <= 18 && $log->gender === 'female') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 19 && $log->age <= 24 && $log->gender === 'male') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 19 && $log->age <= 24 && $log->gender === 'female') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 25 && $log->gender === 'male') ? 'X' : '' }}</td>
            <td style="text-align: center;">{{ ($log->age >= 25 && $log->gender === 'female') ? 'X' : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
