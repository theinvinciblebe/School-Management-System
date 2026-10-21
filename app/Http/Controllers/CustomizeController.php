<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomizeController extends Controller
{
    public function index()
    {
        $customizes = DB::table('customize')->first(); // Fetch single row
        return view('customize.index', compact('customizes'));
    }

    public function updateLogo(Request $request)
    {
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
                return response()->json(['error' => 'Invalid image format. Allowed: ' . implode(', ', $allowed)], 422);
            }

            $fileName = 'logo_' . time() . '.' . $ext;
            $file->move(public_path('customize_images'), $fileName);

            // Update database
            DB::table('customize')->updateOrInsert(
                ['id' => 1], // Assuming only one row for customization
                ['brand_logo' => $fileName]
            );

            return response()->json([
                'message' => 'School Brand Logo Updated Successfully!',
                'newLogoUrl' => asset('customize_images/' . $fileName) . '?v=' . time()
            ], 200);
        }

        return response()->json(['error' => 'File upload failed: No file received.'], 400);
    }

    public function updateIcon(Request $request)
    {
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
                return response()->json(['error' => 'Invalid icon format. Allowed: ' . implode(', ', $allowed)], 422);
            }

            $fileName = 'icon_' . time() . '.' . $ext;
            $file->move(public_path('customize_images'), $fileName);

            // Also mirror to public/favicon.ico for browser default fallback
            @copy(public_path('customize_images/' . $fileName), public_path('favicon.ico'));

            $dbIconPath = 'customize_images/' . $fileName;

            // Update database with new icon relative path
            DB::table('customize')->updateOrInsert(
                ['id' => 1],
                ['url_icon' => $dbIconPath]
            );

            return response()->json([
                'message' => 'Browser Tab Icon Updated Successfully!',
                'newIconUrl' => asset($dbIconPath) . '?v=' . time()
            ], 200);
        }

        return response()->json(['error' => 'File upload failed: No file received.'], 400);
    }

    public function updateBrandTitle(Request $request)
    {
        $request->validate([
            'brand_title' => 'required|string|max:255', // Ensure it's required and not too long
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1], // Assuming only one customization row
            ['brand_title' => $request->brand_title] // Update brand title
        );

        return response()->json([
            'message' => 'Brand Title Updated Successfully!',
            'newBrandTitle' => $request->brand_title
        ], 200);
    }
    public function updateURLTitle(Request $request)
    {
        $request->validate([
            'url_title' => 'required|string|max:255',
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1], // Assuming only one customization row
            ['url_title' => $request->url_title]
        );

        return response()->json([
            'message' => 'URL Title Updated Successfully!',
            'newURLTitle' => $request->url_title
        ], 200);
    }

    public function getTheme()
    {
        $customization = DB::table('customize')->first();
        return response()->json([
//            'dark_mode' => $customization->dark_mode ?? '',
            'nav_color' => $customization->nav_color ?? '',
            'accent_color' => $customization->accent_color ?? '',
            'sidebar_color' => $customization->sidebar_color ?? '',
            'dark_sidebar_variants' => $customization->dark_sidebar_variants ?? '',
//            'sidebar' => $customization->sidebar ?? 'sidebar-light-primary',
//            'layout' => $customization->layout ?? 'layout-fixed'
        ]);
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            //'dark_mode' => 'nullable|string|max:50',
            'nav_color' => 'nullable|string|max:50',
            'accent_color' => 'nullable|string|max:50',
            'sidebar_color' => 'nullable|string|max:50',
            'dark_sidebar_variants' => 'nullable|string|max:50',
            //'layout' => 'required|string|max:50'
        ]);

        DB::table('customize')->updateOrInsert(
            ['id' => 1], // Single row for customization settings
            [
               // 'dark_mode' => $request->dark_mode,
                'nav_color' => $request->nav_color,
                'accent_color' => $request->accent_color,
                'sidebar_color' => $request->sidebar_color,
                'dark_sidebar_variants' => $request->dark_sidebar_variants,
//                'layout' => $request->layout
            ]
        );

        return response()->json(['success' => true]);
    }


}
