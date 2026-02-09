<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
//aa
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Jobs\SendLoanDueNotifications;
use App\Models\User;
use App\Models\Role;
use App\Models\LoanReturn;
use App\Models\LoanDetail;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

Artisan::command('test:whatsapp', function () {
    $this->info('Iniciando prueba de WhatsApp...');

    // Limpiar usuario previo (primero eliminar dependencias)
    $users = User::where('email', 'test_wapp@example.com')->orWhere('id_user', 12345678)->get();
    foreach($users as $u) {
        // 1. Borrar detalles y préstamos asociados
        $loans = LoanReturn::where('user_id', $u->id)->get();
        foreach($loans as $l) {
             LoanDetail::where('loan_return_id', $l->id)->delete();
             $l->delete();
        }

        // 2. Borrar reservaciones y sus detalles
        $reservations = Reservation::where('user_id', $u->id)->get();
        foreach($reservations as $r) {
            ReservationDetail::where('reservation_id', $r->id)->delete();
            $r->delete();
        }

        $u->delete();
    }

    // 1. Crear/Buscar Usuario
    $user = User::create(
        [
            'email' => 'test_wapp@example.com',
            'name' => 'Kevin',
            'second_name' => 'Test',
            'last_name' => 'User',
            'second_last_name' => '',
            'role_id' => Role::first()?->id ?? 1,
            'password' => bcrypt('password'),
            'nationality' => 'V',
            'id_user' => 12345678,
            'country_code' => '+58',
            'phone' => '4165026559',
            'status' => true,
        ]
    );

    $this->info("Usuario: {$user->name} ({$user->country_code}{$user->phone})");

    // 2. Crear Préstamo que vence en 2 días
    $loan = LoanReturn::create([
        'user_id' => $user->id,
        'return_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        'status' => true,
    ]);

    $this->info("Préstamo creado ID: {$loan->id} para fecha: {$loan->return_date}");

    // 3. Ejecutar Lógica del Job
    $this->info('Ejecutando lógica de notificación...');

    $dueDate = Carbon::now()->addDays(2)->format('Y-m-d');
    $loans = LoanReturn::query()
            ->where('status', true)
            ->whereDate('return_date', $dueDate)
            ->with('user')
            ->get();

    $count = 0;
    foreach ($loans as $loanItem) {
        $u = $loanItem->user;
        if ($u && $u->phone && $u->country_code) {

             // Check if it's our test user
             if($u->id == $user->id) {
                 $phoneNumber = str_replace('+', '', $u->country_code . $u->phone);
                 $this->comment(" -> ENCONTRADO: {$u->name}. Intentando enviar mensaje a {$phoneNumber}...");

                 $message = "Hola {$u->name}, esto es una prueba de la Biblioteca. Tu prestamo vence el {$dueDate}.";

                 // --- CAMBIO A GATEWAY LOCAL ---
                 // $apiKey = '4154492';
                 // $url = "https://api.callmebot.com/whatsapp.php?phone={$phoneNumber}&text=" . urlencode($message) . "&apikey={$apiKey}";

                 $url = "http://localhost:3001/send?phone={$phoneNumber}&message=" . urlencode($message);
                 $this->info(" -> URL LOCAL: $url");

                 try {
                     $response = Http::timeout(15)->get($url);
                     $this->info(" -> STATUS: " . $response->status());
                     $this->info(" -> BODY: " . $response->body());

                     if ($response->successful()) {
                         $this->info(' -> MENSAJE ENVIADO CORRECTAMENTE (Según API)');
                     } else {
                         $this->error(' -> MENSAJE FALLIDO');
                     }
                 } catch (\Exception $e) {
                     $this->error(" -> ERROR DE CONEXIÓN: " . $e->getMessage());
                 }

                 $count++;
             }
        }
    }

    if ($count > 0) {
        $this->info('¡Prueba EXITOSA! Se encontró el usuario y se generó el log de envío.');
    } else {
        $this->error('FALLO: No se encontró el préstamo para notificar.');
    }

})->purpose('Test Whatsapp Logic');

Schedule::job(new SendLoanDueNotifications)->dailyAt('10:00');

