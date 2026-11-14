<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\User;
use PDO;

class InstallerController extends Controller
{
    /**
     * Display the Modern Installation Wizard.
     */
    public function index(Request $request)
    {
        // 1. PHP Version Check
        $minPhpVersion = '8.2.0';
        $currentPhpVersion = PHP_VERSION;
        $phpSatisfied = version_compare($currentPhpVersion, $minPhpVersion, '>=');

        // 2. Required PHP Extensions Check
        $requiredExtensions = [
            'pdo'       => 'PDO Library',
            'openssl'   => 'OpenSSL Cryptography',
            'mbstring'  => 'Multibyte String',
            'tokenizer' => 'Tokenizer Support',
            'xml'       => 'XML Parser',
            'ctype'     => 'Ctype Functions',
            'json'      => 'JSON Serialization',
            'bcmath'    => 'BCMath High Precision Math',
            'curl'      => 'cURL Client',
            'fileinfo'  => 'FileInfo MIME Detector',
            'gd'        => 'GD Image Library',
            'intl'      => 'Internationalization (Intl)',
        ];

        $extensionResults = [];
        $allExtensionsSatisfied = true;
        foreach ($requiredExtensions as $ext => $name) {
            $loaded = extension_loaded($ext);
            $extensionResults[] = [
                'extension' => $ext,
                'name'      => $name,
                'satisfied' => $loaded,
            ];
            if (!$loaded) {
                $allExtensionsSatisfied = false;
            }
        }

        // 3. Serverless (Vercel) Environment Detection & Directory Permissions
        $isServerless = !empty(getenv('VERCEL')) || !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']) || !empty(getenv('AWS_LAMBDA_FUNCTION_NAME'));

        if ($isServerless) {
            $tmpStorage = (PHP_OS_FAMILY === 'Windows') ? storage_path() : '/tmp/storage';
            $requiredDirs = [
                $tmpStorage,
                $tmpStorage . '/framework',
                $tmpStorage . '/framework/views',
                $tmpStorage . '/framework/sessions',
                $tmpStorage . '/framework/cache',
                $tmpStorage . '/logs',
                $tmpStorage . '/bootstrap/cache',
            ];
            foreach ($requiredDirs as $dir) {
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
            }

            $directories = [
                'storage (/tmp/storage)'          => $tmpStorage,
                'storage/framework'               => $tmpStorage . '/framework',
                'storage/framework/views'         => $tmpStorage . '/framework/views',
                'storage/logs'                    => $tmpStorage . '/logs',
                'bootstrap/cache'                 => $tmpStorage . '/bootstrap/cache',
                'Environment Variables (Vercel)'  => 'serverless_env',
            ];
        } else {
            $directories = [
                'storage'                  => storage_path(),
                'storage/framework'        => storage_path('framework'),
                'storage/framework/views'  => storage_path('framework/views'),
                'storage/logs'             => storage_path('logs'),
                'bootstrap/cache'          => base_path('bootstrap/cache'),
                '.env'                     => base_path('.env'),
            ];
        }

        $directoryResults = [];
        $allDirectoriesSatisfied = true;
        foreach ($directories as $label => $path) {
            if ($path === 'serverless_env') {
                $isConfigured = !empty(config('app.key')) || !empty(getenv('APP_KEY'));
                $directoryResults[] = [
                    'label'     => $label,
                    'path'      => 'Vercel Project Dashboard',
                    'satisfied' => $isConfigured,
                    'badge'     => $isConfigured ? __('Configured') : __('Missing APP_KEY'),
                    'subtext'   => __('Managed via Vercel Dashboard'),
                ];
                if (!$isConfigured) {
                    $allDirectoriesSatisfied = false;
                }
                continue;
            }

            $isWritable = $this->isPathWritable($path);
            $directoryResults[] = [
                'label'     => $label,
                'path'      => $path,
                'satisfied' => $isWritable,
                'badge'     => $isWritable ? __('Writable') : __('Not Writable'),
                'subtext'   => null,
            ];
            if (!$isWritable) {
                $allDirectoriesSatisfied = false;
            }
        }

        $systemReady = $phpSatisfied && $allExtensionsSatisfied && $allDirectoriesSatisfied;

        // 4. Current Database Connection Check
        $dbConnected = false;
        $tableCount = 0;
        $dbError = null;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
            $tableCount = count(DB::select('SELECT 1 FROM ' . (DB::getDriverName() === 'pgsql' ? 'information_schema.tables' : (DB::getDriverName() === 'sqlite' ? 'sqlite_master' : 'information_schema.tables'))));
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        // 5. Existing School Customization Information
        $customize = null;
        try {
            $customize = DB::table('customize')->first();
        } catch (\Throwable $e) {}

        // 6. Existing Admin User Check
        $existingAdmin = null;
        try {
            $existingAdmin = User::where('role', 0)->first();
        } catch (\Throwable $e) {}

        $isInstalled = file_exists(storage_path('installed'));

        return view('installer.index', compact(
            'minPhpVersion',
            'currentPhpVersion',
            'phpSatisfied',
            'extensionResults',
            'allExtensionsSatisfied',
            'directoryResults',
            'allDirectoriesSatisfied',
            'systemReady',
            'dbConnected',
            'tableCount',
            'dbError',
            'customize',
            'existingAdmin',
            'isInstalled',
            'isServerless'
        ));
    }

    /**
     * Test a dynamic database connection without modifying the environment.
     */
    public function testDatabase(Request $request)
    {
        $driver = $request->input('driver', 'mysql');
        $host = $request->input('host', '127.0.0.1');
        $port = $request->input('port', $driver === 'pgsql' ? '5432' : '3306');
        $database = $request->input('database', '');
        $username = $request->input('username', '');
        $password = $request->input('password', '');

        try {
            if ($driver === 'sqlite') {
                $dbPath = $database ?: database_path('database.sqlite');
                if (!str_starts_with($dbPath, '/') && !preg_match('/^[A-Za-z]:/', $dbPath)) {
                    $dbPath = base_path($dbPath);
                }
                if (!file_exists($dbPath)) {
                    @touch($dbPath);
                }
                new PDO("sqlite:{$dbPath}");
            } elseif ($driver === 'pgsql') {
                $dsn = "pgsql:host={$host};port={$port};dbname={$database};";
                new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
            } else {
                // Default mysql
                $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
                new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
            }

            return response()->json([
                'success' => true,
                'message' => __('Database connection successfully established!'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Connection failed: ') . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Setup Database & execute migrations.
     */
    public function setupDatabase(Request $request)
    {
        $driver = $request->input('driver');
        $host = $request->input('host');
        $port = $request->input('port');
        $database = $request->input('database');
        $username = $request->input('username');
        $password = $request->input('password');

        // Optional .env update
        if ($driver === 'sqlite') {
            $this->updateEnv([
                'DB_CONNECTION' => 'sqlite',
            ]);
        } elseif ($driver && $database) {
            $this->updateEnv([
                'DB_CONNECTION' => $driver,
                'DB_HOST'       => $host ?? '127.0.0.1',
                'DB_PORT'       => $port ?? ($driver === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE'   => str_replace('\\', '/', $database),
                'DB_USERNAME'   => $username ?? '',
                'DB_PASSWORD'   => $password ?? '',
            ]);
        }

        try {
            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => __('Database schema migrated successfully!'),
                'output'  => $migrateOutput,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Migration error: ') . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Save School Profile & Branding Customizations.
     */
    public function saveSchool(Request $request)
    {
        $validated = $request->validate([
            'brand_title'    => 'required|string|max:255',
            'school_email'   => 'nullable|email|max:255',
            'school_phone'   => 'nullable|string|max:100',
            'school_address' => 'nullable|string|max:500',
            'accent_color'   => 'nullable|string|max:50',
        ]);

        try {
            $existing = DB::table('customize')->first();
            $data = [
                'brand_title'    => $validated['brand_title'],
                'url_title'      => $validated['brand_title'],
                'school_email'   => $validated['school_email'] ?? 'info@schoolsystem.edu.kh',
                'school_phone'   => $validated['school_phone'] ?? '+855 12 801 470 / +855 71 220 6315',
                'school_address' => $validated['school_address'] ?? 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia',
                'accent_color'   => $validated['accent_color'] ?? 'accent-indigo',
                'updated_at'     => now(),
            ];

            if ($existing) {
                DB::table('customize')->where('id', $existing->id)->update($data);
            } else {
                $data['created_at'] = now();
                DB::table('customize')->insert($data);
            }

            return response()->json([
                'success' => true,
                'message' => __('School profile & branding saved successfully!'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to save school profile: ') . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create or update the Super Administrator Account.
     */
    public function createAdmin(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $admin = User::where('role', 0)->first();

            if ($admin) {
                $admin->name = $validated['name'];
                $admin->email = $validated['email'];
                $admin->password = Hash::make($validated['password']);
                $admin->save();
            } else {
                $admin = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 0, // 0 = Admin
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => __('Super Administrator account configured successfully!'),
                'admin'   => [
                    'name'  => $admin->name,
                    'email' => $admin->email,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to configure admin account: ') . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Finalize the installation and lock wizard.
     */
    public function finalize(Request $request)
    {
        try {
            $installedData = json_encode([
                'installed_at' => now()->toIso8601String(),
                'version'      => '2.0.0',
                'environment'  => config('app.env', 'production'),
            ], JSON_PRETTY_PRINT);

            @file_put_contents(storage_path('installed'), $installedData);
            @file_put_contents(base_path('storage/installed'), $installedData);
            if (!empty(getenv('VERCEL')) || PHP_OS_FAMILY !== 'Windows') {
                @file_put_contents('/tmp/storage/installed', $installedData);
                @file_put_contents('/tmp/installed', $installedData);
            }

            try {
                Artisan::call('view:clear');
                Artisan::call('cache:clear');
            } catch (\Throwable $e) {}

            return response()->json([
                'success' => true,
                'message' => __('Installation finalized successfully! Welcome to your new School Management System.'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to finalize installation: ') . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper to safely update key=value pairs in the .env file.
     */
    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath) || !is_writable($envPath)) {
            // In read-only serverless environments (Vercel), .env is read-only.
            // Put in environment memory for the current process instead:
            foreach ($data as $key => $value) {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
            return;
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $key = strtoupper(trim($key));
            // Normalize any Windows backslashes to forward slashes to prevent phpdotenv escape sequence errors
            $value = str_replace('\\', '/', (string) $value);

            // Escape quotes or wrap if contains spaces or hash
            if (preg_match('/[\s#]/', $value)) {
                $escapedValue = '"' . addcslashes($value, '"') . '"';
            } else {
                $escapedValue = $value;
            }

            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
            } else {
                $envContent .= "\n{$key}={$escapedValue}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Cross-platform check if a file or directory is truly writable.
     */
    protected function isPathWritable($path): bool
    {
        if (is_file($path)) {
            if (is_writable($path)) {
                return true;
            }
            $fp = @fopen($path, 'a');
            if ($fp) {
                fclose($fp);
                return true;
            }
            return false;
        }

        if (!file_exists($path)) {
            @mkdir($path, 0755, true);
        }

        if (!is_dir($path)) {
            return false;
        }

        // Test actual write/delete capability
        $testFile = rtrim($path, '/\\') . '/.write_test_' . uniqid();
        $written = @file_put_contents($testFile, 'test');
        if ($written !== false) {
            @unlink($testFile);
            return true;
        }

        return is_writable($path);
    }
}

