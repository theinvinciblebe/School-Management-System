<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomizeController extends Controller
{
    public function index()
    {
        $customizes = DB::table('customize')->first();
        return view('customize.index', compact('customizes'));
    }

    /**
     * Ensure column is TEXT on PostgreSQL for storing Data URIs.
     */
    protected function ensureColumnIsText(string $column): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            try {
                DB::statement("ALTER TABLE \"customize\" ALTER COLUMN \"{$column}\" TYPE text;");
            } catch (\Throwable $e) {
                // Silently ignore if already text or lacks alter permission
            }
        }
    }

    public function updateLogo(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,jpg,gif,ico,webp,svg|max:4096',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $ext = strtolower($file->getClientOriginalExtension());
                if (!$ext) {
                    $ext = strtolower($file->guessExtension() ?? 'png');
                }

                $allowed = ['jpeg', 'jpg', 'png', 'gif', 'ico', 'webp', 'svg'];
                if (!in_array($ext, $allowed)) {
                    return response()->json(['error' => __('Invalid image format. Allowed: ') . implode(', ', $allowed)], 422);
                }

                $this->ensureColumnIsText('brand_logo');

                $fileContents = file_get_contents($file->getRealPath());
                $mime = match ($ext) {
                    'svg'         => 'image/svg+xml',
                    'jpg', 'jpeg' => 'image/jpeg',
                    'png'         => 'image/png',
                    'gif'         => 'image/gif',
                    'webp'        => 'image/webp',
                    'ico'         => 'image/x-icon',
                    default       => $file->getMimeType() ?: 'image/png',
                };
                $dataUri = 'data:' . $mime . ';base64,' . base64_encode($fileContents);

                $fileName = 'logo_' . time() . '.' . $ext;

                // Try to write to public/customize_images if filesystem is writable (Local)
                $wroteToDisk = false;
                try {
                    $targetDir = public_path('customize_images');
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    if (is_writable($targetDir)) {
                        @file_put_contents($targetDir . '/' . $fileName, $fileContents);
                        $wroteToDisk = true;
                    }
                } catch (\Throwable $e) {}

                $isServerless = !empty(getenv('VERCEL')) || !empty($_ENV['VERCEL']) || (PHP_OS_FAMILY !== 'Windows' && !$wroteToDisk);
                $savedValue = ($isServerless || !$wroteToDisk) ? $dataUri : $fileName;

                // Update database
                DB::table('customize')->updateOrInsert(
                    ['id' => 1],
                    ['brand_logo' => $savedValue]
                );

                $returnUrl = str_starts_with($savedValue, 'data:') ? $savedValue : (asset('customize_images/' . $savedValue) . '?v=' . time());

                return response()->json([
                    'message'    => __('School Brand Logo Updated Successfully!'),
                    'newLogoUrl' => $returnUrl,
                ], 200);
            }

            return response()->json(['error' => __('File upload failed: No file received.')], 400);
        } catch (\Throwable $e) {
            Log::error('Logo upload error: ' . $e->getMessage());
            return response()->json(['error' => __('Upload failed: ') . $e->getMessage()], 500);
        }
    }

    public function updateIcon(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,ico,webp,svg|max:4096',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $ext = strtolower($file->getClientOriginalExtension());
                if (!$ext) {
                    $ext = strtolower($file->guessExtension() ?? 'ico');
                }

                $allowed = ['jpeg', 'jpg', 'png', 'gif', 'ico', 'webp', 'svg'];
                if (!in_array($ext, $allowed)) {
                    return response()->json(['error' => __('Invalid icon format. Allowed: ') . implode(', ', $allowed)], 422);
                }

                $this->ensureColumnIsText('url_icon');

                $fileContents = file_get_contents($file->getRealPath());
                $mime = match ($ext) {
                    'ico'         => 'image/x-icon',
                    'svg'         => 'image/svg+xml',
                    'jpg', 'jpeg' => 'image/jpeg',
                    'png'         => 'image/png',
                    'gif'         => 'image/gif',
                    'webp'        => 'image/webp',
                    default       => $file->getMimeType() ?: 'image/png',
                };
                $dataUri = 'data:' . $mime . ';base64,' . base64_encode($fileContents);

                $fileName = 'icon_' . time() . '.' . $ext;
                $dbIconPath = 'customize_images/' . $fileName;

                // Try to write to public/customize_images and public/favicon.ico if filesystem is writable (Local)
                $wroteToDisk = false;
                try {
                    $targetDir = public_path('customize_images');
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    if (is_writable($targetDir)) {
                        @file_put_contents($targetDir . '/' . $fileName, $fileContents);
                        if (is_writable(public_path())) {
                            @file_put_contents(public_path('favicon.ico'), $fileContents);
                        }
                        $wroteToDisk = true;
                    }
                } catch (\Throwable $e) {}

                $isServerless = !empty(getenv('VERCEL')) || !empty($_ENV['VERCEL']) || (PHP_OS_FAMILY !== 'Windows' && !$wroteToDisk);
                $savedValue = ($isServerless || !$wroteToDisk) ? $dataUri : $dbIconPath;

                // Update database with new icon relative path or Data URI
                DB::table('customize')->updateOrInsert(
                    ['id' => 1],
                    ['url_icon' => $savedValue]
                );

                $returnUrl = str_starts_with($savedValue, 'data:') ? $savedValue : (asset($savedValue) . '?v=' . time());

                return response()->json([
                    'message'    => __('Browser Tab Icon Updated Successfully!'),
                    'newIconUrl' => $returnUrl,
                ], 200);
            }

            return response()->json(['error' => __('File upload failed: No file received.')], 400);
        } catch (\Throwable $e) {
            Log::error('Icon upload error: ' . $e->getMessage());
            return response()->json(['error' => __('Upload failed: ') . $e->getMessage()], 500);
        }
    }

    public function updateBrandTitle(Request $request)
    {
        $request->validate([
            'brand_title' => 'required|string|max:255',
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1],
            ['brand_title' => $request->brand_title]
        );

        return response()->json([
            'message'       => __('Brand Title Updated Successfully!'),
            'newBrandTitle' => $request->brand_title,
        ], 200);
    }

    public function updateURLTitle(Request $request)
    {
        $request->validate([
            'url_title' => 'required|string|max:255',
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1],
            ['url_title' => $request->url_title]
        );

        return response()->json([
            'message'     => __('URL Title Updated Successfully!'),
            'newURLTitle' => $request->url_title,
        ], 200);
    }

    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'school_address' => 'nullable|string|max:500',
            'school_phone'   => 'nullable|string|max:100',
            'school_email'   => 'nullable|string|max:150',
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1],
            [
                'school_address' => $request->school_address,
                'school_phone'   => $request->school_phone,
                'school_email'   => $request->school_email,
            ]
        );

        return response()->json([
            'message'        => __('School Contact Info Updated Successfully!'),
            'school_address' => $request->school_address,
            'school_phone'   => $request->school_phone,
            'school_email'   => $request->school_email,
        ], 200);
    }

    public function getTheme()
    {
        $customization = DB::table('customize')->first();
        return response()->json([
            'nav_color'             => $customization->nav_color ?? '',
            'accent_color'          => $customization->accent_color ?? '',
            'sidebar_color'         => $customization->sidebar_color ?? '',
            'dark_sidebar_variants' => $customization->dark_sidebar_variants ?? '',
        ]);
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'nav_color'             => 'nullable|string|max:50',
            'accent_color'          => 'nullable|string|max:50',
            'sidebar_color'         => 'nullable|string|max:50',
            'dark_sidebar_variants' => 'nullable|string|max:50',
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1],
            [
                'nav_color'             => $request->nav_color,
                'accent_color'          => $request->accent_color,
                'sidebar_color'         => $request->sidebar_color,
                'dark_sidebar_variants' => $request->dark_sidebar_variants,
            ]
        );

        return response()->json(['success' => true]);
    }
}
