<?php

namespace App\Jobs;

use App\Models\LoanReturn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendLoanDueNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Rango: Desde HOY hasta dentro de 2 DÍAS
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDays(2)->format('Y-m-d');

        Log::info("WAPP_JOB: Buscando préstamos pendientes entre {$startDate} y {$endDate}...");

        $loans = LoanReturn::query()
            ->with(['user', 'loanDetails.copyBook.book'])
            ->where('status', true) 
            ->whereBetween('return_date', [$startDate, $endDate])
            ->get();

        Log::info("WAPP_JOB: Préstamos encontrados: " . $loans->count());

        foreach ($loans as $loan) {
            $user = $loan->user;

            if ($user && $user->phone && $user->country_code) {
                // Formato telefónico (quitar el +) -> 584121234567
                $phoneNumber = str_replace('+', '', $user->country_code . $user->phone); 
                
                $msgDate = Carbon::parse($loan->return_date)->format('d/m/Y');
                $message = "Hola {$user->name}, recordatorio de Biblioteca: Tu prestamo vence el {$msgDate}.";
                
                // --- OPCIÓN 3: Gateway Local (whatsapp-web.js) ---
                // Servidor Node.js corriendo en el puerto 3001
                $url = "http://localhost:3001/send?phone={$phoneNumber}&message=" . urlencode($message);
                
                try {
                    $response = Http::timeout(10)->get($url);
                    if ($response->successful()) {
                         Log::info("WAPP_ENVIADO (Local): Mensaje enviado a {$phoneNumber}. Resp: " . $response->body());
                    } else {
                         Log::error("WAPP_FALLO (Local): Status " . $response->status() . " Body: " . $response->body());
                    }
                } catch (\Exception $e) {
                    Log::error("WAPP_ERROR (Local): Asegurate de correr 'node server.js'. Error: " . $e->getMessage());
                }
            }
        }
    }
}

