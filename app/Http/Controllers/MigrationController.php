<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\BufferedOutput;

class MigrationController extends Controller
{
    /**
     * Check authorization for running database migrations via web.
     */
    protected function isAuthorized(Request $request): bool
    {
        $migrateKey = env('MIGRATE_KEY');
        if (!empty($migrateKey)) {
            $providedKey = $request->input('key') ?? $request->header('X-Migrate-Key');
            if ($providedKey === $migrateKey) {
                return true;
            }

            // Also check logged-in admin
            if (auth()->check() && (int) auth()->user()->role === 0) {
                return true;
            }

            return false;
        }

        // If no MIGRATE_KEY configured, allow access
        return true;
    }

    /**
     * Get Database Information summary for the UI.
     */
    protected function getDatabaseInfo(): array
    {
        $defaultConn = config('database.default', 'mysql');
        $connConfig = config("database.connections.{$defaultConn}", []);

        $isServerless = !empty(getenv('VERCEL'))
            || !empty($_ENV['VERCEL'])
            || !empty($_SERVER['VERCEL'])
            || !empty(getenv('AWS_LAMBDA_FUNCTION_NAME'));

        return [
            'driver'       => $defaultConn,
            'host'         => $connConfig['host'] ?? '127.0.0.1',
            'port'         => $connConfig['port'] ?? ($defaultConn === 'pgsql' ? '5432' : '3306'),
            'database'     => basename($connConfig['database'] ?? 'school'),
            'username'     => $connConfig['username'] ?? '',
            'environment'  => config('app.env', 'production'),
            'isServerless' => $isServerless,
        ];
    }

    /**
     * Clean ANSI terminal color escape codes from output.
     */
    protected function cleanOutput(string $output): string
    {
        return preg_replace('#\x1b[[][^A-Za-z]*[A-Za-z]#', '', $output);
    }

    /**
     * Render response (JSON or Web Console UI).
     */
    protected function respond(Request $request, array $data, int $statusCode = 200)
    {
        if ($request->expectsJson() || $request->query('format') === 'json') {
            return response()->json($data, $statusCode);
        }

        $dbInfo = $this->getDatabaseInfo();

        return response()->view('installer.migration', array_merge([
            'dbInfo'        => $dbInfo,
            'action'        => $data['action'] ?? 'console',
            'success'       => $data['success'] ?? true,
            'message'       => $data['message'] ?? '',
            'output'        => $data['output'] ?? '',
            'duration'      => $data['duration'] ?? null,
            'statusCode'    => $statusCode,
        ], $data), $statusCode);
    }

    /**
     * Show Migration Console UI (Index).
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'index',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        return $this->respond($request, [
            'success'  => true,
            'action'   => 'console',
            'message'  => __('Database Operations Console ready.'),
            'output'   => __('No console output available. Select an action above to execute.'),
            'duration' => null,
        ]);
    }

    /**
     * Run both Migration and Seeding.
     */
    public function migrateSeed(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'migrate-seed',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        @set_time_limit(300);
        @ini_set('memory_limit', '512M');
        $startTime = microtime(true);

        try {
            // 1. Run Migrations
            $buffer = new BufferedOutput();
            $migrateExit = Artisan::call('migrate', ['--force' => true], $buffer);
            $migrateOutput = $buffer->fetch();

            // 2. Run Seeders
            $seedBuffer = new BufferedOutput();
            $seedExit = Artisan::call('db:seed', ['--force' => true], $seedBuffer);
            $seedOutput = $seedBuffer->fetch();

            $fullOutput = "=== 1. DATABASE MIGRATIONS ===\n" . $migrateOutput . "\n\n=== 2. DATABASE SEEDERS ===\n" . $seedOutput;
            $cleanOutput = $this->cleanOutput($fullOutput);
            $duration = round(microtime(true) - $startTime, 2);

            return $this->respond($request, [
                'success'  => ($migrateExit === 0 && $seedExit === 0),
                'action'   => 'migrate-seed',
                'message'  => __('Database schema migrated and seeded successfully!'),
                'output'   => $cleanOutput,
                'duration' => $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            return $this->respond($request, [
                'success'  => false,
                'action'   => 'migrate-seed',
                'message'  => __('Execution failed: ') . $e->getMessage(),
                'output'   => "ERROR:\n" . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString(),
                'duration' => $duration,
            ], 500);
        }
    }

    /**
     * Run Migrations only.
     */
    public function migrate(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'migrate',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        @set_time_limit(300);
        @ini_set('memory_limit', '512M');
        $startTime = microtime(true);

        try {
            $buffer = new BufferedOutput();
            $exitCode = Artisan::call('migrate', ['--force' => true], $buffer);
            $output = $this->cleanOutput($buffer->fetch());
            $duration = round(microtime(true) - $startTime, 2);

            return $this->respond($request, [
                'success'  => ($exitCode === 0),
                'action'   => 'migrate',
                'message'  => __('Database schema migrated successfully!'),
                'output'   => $output,
                'duration' => $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            return $this->respond($request, [
                'success'  => false,
                'action'   => 'migrate',
                'message'  => __('Execution failed: ') . $e->getMessage(),
                'output'   => "ERROR:\n" . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString(),
                'duration' => $duration,
            ], 500);
        }
    }

    /**
     * Run Database Seeders only.
     */
    public function seed(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'seed',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        @set_time_limit(300);
        @ini_set('memory_limit', '512M');
        $startTime = microtime(true);

        try {
            $params = ['--force' => true];
            if ($request->has('class')) {
                $params['--class'] = $request->input('class');
            }

            $buffer = new BufferedOutput();
            $exitCode = Artisan::call('db:seed', $params, $buffer);
            $output = $this->cleanOutput($buffer->fetch());
            $duration = round(microtime(true) - $startTime, 2);

            return $this->respond($request, [
                'success'  => ($exitCode === 0),
                'action'   => 'seed',
                'message'  => __('Database seeded successfully!'),
                'output'   => $output,
                'duration' => $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            return $this->respond($request, [
                'success'  => false,
                'action'   => 'seed',
                'message'  => __('Execution failed: ') . $e->getMessage(),
                'output'   => "ERROR:\n" . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString(),
                'duration' => $duration,
            ], 500);
        }
    }

    /**
     * Show Migration Status.
     */
    public function status(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'status',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        @set_time_limit(60);
        $startTime = microtime(true);

        try {
            $buffer = new BufferedOutput();
            Artisan::call('migrate:status', [], $buffer);
            $output = $this->cleanOutput($buffer->fetch());
            $duration = round(microtime(true) - $startTime, 2);

            return $this->respond($request, [
                'success'  => true,
                'action'   => 'status',
                'message'  => __('Migration status retrieved successfully!'),
                'output'   => $output,
                'duration' => $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            return $this->respond($request, [
                'success'  => false,
                'action'   => 'status',
                'message'  => __('Execution failed: ') . $e->getMessage(),
                'output'   => "ERROR:\n" . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString(),
                'duration' => $duration,
            ], 500);
        }
    }

    /**
     * Fresh migration and re-seeding (destructive - requires confirmation).
     */
    public function freshSeed(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'fresh-seed',
                'message' => __('Unauthorized access. Invalid or missing MIGRATE_KEY.'),
                'output'  => __('Please provide ?key=YOUR_KEY or sign in as an Administrator.'),
            ], 403);
        }

        // Must explicitly pass confirm=yes or confirmation header
        if ($request->input('confirm') !== 'yes') {
            return $this->respond($request, [
                'success' => false,
                'action'  => 'fresh-seed',
                'message' => __('Action aborted. Fresh migration requires confirmation (?confirm=yes).'),
                'output'  => __('Safety protection: Re-running migrate:fresh drops all tables. To proceed, pass confirm=yes.'),
            ], 400);
        }

        @set_time_limit(300);
        @ini_set('memory_limit', '512M');
        $startTime = microtime(true);

        try {
            $buffer = new BufferedOutput();
            $exitCode = Artisan::call('migrate:fresh', [
                '--seed'  => true,
                '--force' => true,
            ], $buffer);

            $output = $this->cleanOutput($buffer->fetch());
            $duration = round(microtime(true) - $startTime, 2);

            return $this->respond($request, [
                'success'  => ($exitCode === 0),
                'action'   => 'fresh-seed',
                'message'  => __('Fresh migration and seeding completed successfully!'),
                'output'   => $output,
                'duration' => $duration,
            ]);
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            return $this->respond($request, [
                'success'  => false,
                'action'   => 'fresh-seed',
                'message'  => __('Execution failed: ') . $e->getMessage(),
                'output'   => "ERROR:\n" . $e->getMessage() . "\n\nStack trace:\n" . $e->getTraceAsString(),
                'duration' => $duration,
            ], 500);
        }
    }
}
