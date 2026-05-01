<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    protected function authorizeTeacherAccess()
    {
        if (!in_array(Auth::user()->role, [0, 1])) {
            abort(403);
        }
    }

    protected function authorizeAccountantAccess()
    {
        if (!in_array(Auth::user()->role, [0, 3, 4])) {
            abort(403);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function myClass()
    {
        $user = Auth::user();
        $classes = collect(); // Initialize as an empty collection to prevent errors

        // If user is an admin
        if ($user->role === 0) {
            $classes = DB::table('class')->get();
        }
        // If user is a teacher
        else if ($user->role === 1) {
            $classes = DB::table('class')
                ->leftjoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.*') // Select only class columns to avoid conflicts
                ->get();
        }
        // If user is a student
        else if ($user->role === 2) {
            $classes = DB::table('class')
                ->join('student_classes', 'class.class_id', '=', 'student_classes.class_id')
                ->join('student', 'student_classes.student_id', '=', 'student.student_id')
                ->where('student.user_id', $user->id)
                ->select('class.*')
                ->get();
        }

//        dd([
//            'user_id' => $user->id,
//            'user_role' => $user->role,
//        ]);

        return view('myClass.index', compact('classes'));
    }

    public function getSubject($class_id)
    {
        // Check if the class exists
        $classExists = DB::table('class')->where('class_id', $class_id)->exists();
        if (!$classExists) {
            return redirect()->back()->with('error', 'Class not found.');
        }
        $class = DB::table('class')->where('class_id', $class_id)->first();
        // Fetch the subjects for this class
        $subjects = DB::table('subject')
            ->join('teacher', 'subject.teacher_id', '=', 'teacher.teacher_id')
            ->where('subject.class_id', $class_id)
            ->select('subject.*', 'teacher.name as teacher_name') // Fetch class name
            ->get();

        // Debugging: Check if subjects are found
        if ($subjects->isEmpty()) {
            return redirect()->back()->with('error', 'No subjects found for this class.');
        }

        return view('myClass.getSubjects', compact('subjects', 'class'));
    }
    public function getMaterials($subject_id)
    {
        // Fetch the class details
        $subject = DB::table('subject')->where('subject_id', $subject_id)->first();

        if (!$subject) {
            return redirect()->back()->with('error', 'Subject not found.');
        }

        // Fetch class materials
        $materials = DB::table('class_materials')
            ->where('subject_id', $subject_id)
            ->orderBy('created_at', 'desc') // Order by newest first
            ->get();

        // Convert all YouTube links to embed format
        foreach ($materials as $material) {
            if (!empty($material->url_vdo)) {
                $videoUrl = $material->url_vdo;

                // If URL is a short link (youtu.be)
                if (strpos($videoUrl, 'youtu.be/') !== false) {
                    $videoId = explode('youtu.be/', $videoUrl)[1];
                    $material->url_vdo = "https://www.youtube.com/embed/{$videoId}";
                }
                // If URL is a standard YouTube link (watch?v= format)
                elseif (strpos($videoUrl, 'watch?v=') !== false) {
                    $videoId = explode('watch?v=', $videoUrl)[1];
                    $videoId = explode('&', $videoId)[0]; // Remove extra parameters
                    $material->url_vdo = "https://www.youtube.com/embed/{$videoId}";
                }
                // If the video is stored locally
                elseif (preg_match('/\.(mp4|avi|mov|mkv)$/i', $videoUrl)) {
                    $material->video_url = asset('upload_materials/' . $videoUrl);
                }
            }
        }

        return view('myClass.material_list', compact('subject', 'materials'));
    }

    // Display the form for creating a new material
    public function createMaterial($subject_id)
    {
        // Fetch the subject details
        $subject = DB::table('subject')->where('subject_id', $subject_id)->first();

        if (!$subject) {
            return redirect()->back()->with('error', 'Subject not found.');
        }

        return view('myClass.add_material', compact('subject'));
    }

    // Store the submitted material data
    public function createMaterials(Request $request)
    {
        $this->authorizeTeacherAccess();

        try {
            $request->validate([
                'subject_id' => 'required',
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'gallery_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
                'file_path.*' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:20480',
                'url_vdo' => 'nullable|string',
                'video_file.*' => 'nullable|mimes:mp4,avi,mov,mkv|max:1024000', // 1GB limit per video (in KB)
            ]);

            // Define upload destination
            $destinationPath = public_path('upload_materials');

            // Handle gallery image uploads
            $galleryPaths = [];
            if ($request->hasFile('gallery_path')) {
                foreach ($request->file('gallery_path') as $image) {
                    $imageName = time() . '_gallery_' . $image->getClientOriginalName();
                    $image->move($destinationPath, $imageName);
                    $galleryPaths[] = $imageName;
                }
            }

            // Handle document uploads
            $documentPaths = [];
            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $document) {
                    $documentName = time() . '_doc_' . $document->getClientOriginalName();
                    $document->move($destinationPath, $documentName);
                    $documentPaths[] = $documentName;
                }
            }

            // Handle video (YouTube URL or Local)
            $videoPaths = [];
            if ($request->filled('url_vdo')) {
                $videoLinks = explode(',', $request->url_vdo);

                foreach ($videoLinks as $link) {
                    $link = trim($link);

                    if (strpos($link, 'youtu.be/') !== false) {
                        $videoId = explode('youtu.be/', $link)[1];
                        $videoPaths[] = "https://www.youtube.com/embed/{$videoId}";
                    } elseif (strpos($link, 'watch?v=') !== false) {
                        $videoId = explode('watch?v=', $link)[1];
                        $videoId = explode('&', $videoId)[0];
                        $videoPaths[] = "https://www.youtube.com/embed/{$videoId}";
                    } else {
                        $videoPaths[] = $link;
                    }
                }
            }
            if ($request->hasFile('video_file')) {
                foreach ($request->file('video_file') as $video) {
                    $videoName = time() . '_video_' . $video->getClientOriginalName();
                    $video->move($destinationPath, $videoName);
                    $videoPaths[] = $videoName;
                }
            }

            // Get Authenticated User
            $authorName = Auth::user()->name;

            // Insert into class_materials table
            DB::table('class_materials')->insert([
                'subject_id' => $request->subject_id,
                'author_name' => $authorName,
                'title' => $request->title,
                'description' => $request->description,
                'gallery_path' => json_encode($galleryPaths),
                'file_path' => json_encode($documentPaths),
                'url_vdo' => json_encode($videoPaths),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('class.materials', ['subject_id' => $request->subject_id])->with('success', 'Material added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateDescription(Request $request, $id)
    {
        $this->authorizeTeacherAccess();

        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Update only the description field
        DB::table('class_materials')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Description updated successfully!']);
    }
    public function deleteDescription($id)
    {
        $this->authorizeTeacherAccess();

        try{
         DB::table('class_materials')
            ->where('id', $id)
            ->update([
                'title' => null,
                'description' => null,
            ]);

            return redirect()->back()->with('success', 'Description and title deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete description and title: ' . $e->getMessage());
        }
    }

    public function updateVideos(Request $request, $id)
    {
        $this->authorizeTeacherAccess();

        $request->validate([
            'url_vdo' => 'nullable|string',
            'video_file.*' => 'nullable|mimes:mp4,avi,mov,mkv|max:1048576', // Support multiple files
        ]);

        // Fetch existing material
        $material = DB::table('class_materials')->where('id', $id)->first();

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Retrieve existing videos
        $existingVideos = !empty($material->url_vdo) ? json_decode($material->url_vdo, true) : [];
        $videoPaths = is_array($existingVideos) ? $existingVideos : [];

        // Handle YouTube or External Video URLs
        if ($request->filled('url_vdo')) {
            $videoLinks = explode(',', $request->url_vdo); // Convert to array

            foreach ($videoLinks as $link) {
                $link = trim($link);

                // Validate if it's a valid URL
                if (!filter_var($link, FILTER_VALIDATE_URL)) {
                    continue; // Skip invalid URLs
                }

                // Parse YouTube Links
                if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    $videoId = $matches[1];
                    $videoPaths[] = "https://www.youtube.com/embed/{$videoId}";
                } elseif (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    $videoId = $matches[1];
                    $videoPaths[] = "https://www.youtube.com/embed/{$videoId}";
                } else {
                    // If it's another valid URL
                    $videoPaths[] = $link;
                }
            }
        }

        // Handle Uploaded Video Files
        if ($request->hasFile('video_file')) {
            $destinationPath = public_path('upload_materials');

            foreach ($request->file('video_file') as $video) {
                if ($video->isValid()) {
                    $videoName = time() . '_video_' . $video->getClientOriginalName();
                    $video->move($destinationPath, $videoName);
                    $videoPaths[] = $videoName;
                }
            }
        }

        // Remove duplicates (if any)
        $videoPaths = array_values(array_unique($videoPaths));

        // If no videos left, store `null` instead of `[]`
        $finalVideos = count($videoPaths) > 0 ? json_encode($videoPaths) : null;

        // Update Database
        DB::table('class_materials')->where('id', $id)->update([
            'url_vdo' => $finalVideos,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Videos updated successfully!');
    }
    public function deleteVideos($id)
    {
        $this->authorizeTeacherAccess();

        try{
            DB::table('class_materials')
                ->where('id', $id)
                ->update([
                    'url_vdo' => null,
                ]);

            return redirect()->back()->with('success', 'Video deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete video: ' . $e->getMessage());
        }
    }

    public function updateFiles(Request $request, $id)
    {
        $this->authorizeTeacherAccess();

        $request->validate([
            'new_files.*' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:20480',
        ]);

        // Fetch existing material
        $material = DB::table('class_materials')->where('id', $id)->first();
        $existingFiles = !empty($material->file_path) ? json_decode($material->file_path, true) : [];

        // Get the updated file list from the request
        $updatedFiles = $request->filled('existing_files') ? json_decode($request->existing_files, true) : [];

        // Handle New File Uploads
        if ($request->hasFile('new_files')) {
            $destinationPath = public_path('upload_materials');

            foreach ($request->file('new_files') as $file) {
                $fileName = time() . '_file_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $updatedFiles[] =  $fileName;
            }
        }

        // Update Database
        DB::table('class_materials')->where('id', $id)->update([
            'file_path' => json_encode($updatedFiles),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Files updated successfully!']);
    }
    public function deleteFiles($id)
    {
        $this->authorizeTeacherAccess();

        try{
            DB::table('class_materials')
                ->where('id', $id)
                ->update([
                    'file_path' => null,
                ]);

            return redirect()->back()->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete file: ' . $e->getMessage());
        }
    }

    public function updateGallery(Request $request, $id)
    {
        $this->authorizeTeacherAccess();

        $request->validate([
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Fetch existing material
        $material = DB::table('class_materials')->where('id', $id)->first();
        $existingGallery = !empty($material->gallery_path) ? json_decode($material->gallery_path, true) : [];

        // Initialize new gallery array
        $galleryPaths = $existingGallery;

        // Handle New Image Uploads
        if ($request->hasFile('gallery_files')) {
            $destinationPath = public_path('upload_materials');

            foreach ($request->file('gallery_files') as $image) {
                $imageName = time() . '_gallery_' . $image->getClientOriginalName();
                $image->move($destinationPath, $imageName);
                $galleryPaths[] = $imageName;
            }
        }

        // Handle Gallery Removal
        if ($request->filled('gallery')) {
            $galleryPaths = json_decode($request->gallery, true);
        }

        // Update Database
        DB::table('class_materials')->where('id', $id)->update([
            'gallery_path' => json_encode($galleryPaths),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Gallery updated successfully!']);
    }
    public function deleteGallery($id)
    {
        $this->authorizeTeacherAccess();

        try{
            DB::table('class_materials')
                ->where('id', $id)
                ->update([
                    'gallery_path' => null,
                ]);

            return redirect()->back()->with('success', 'Gallery deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete gallery: ' . $e->getMessage());
        }
    }




    public function index()
    {
        $tbl = DB::table('class')
            ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
            ->select('class.*', 'teacher.name as teacher_name')
            ->get();

        $teachers = DB::table('teacher')->get(); // Fetch all teachers
        return view("class.index", ['tbl' => $tbl, 'teachers' => $teachers, 'i' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this -> authorizeAccountantAccess();
        // Fetch all teachers to populate the dropdown
        $teachers = DB::table('teacher')->get();

        // Return the view for adding a class
        return view('class.add', compact('teachers'))->with('success', 'Teacher added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all()); // Inspect the submitted data
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'class_code' => 'nullable|string|max:255',
            'class_room' => 'nullable|string|max:255',
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
        ]);

        // Insert the new class into the database
        DB::table('class')->insert([
            'name' => $request->name,
            'class_code' => $request->class_code,
            'class_room' => $request->class_room,
            'teacher_id' => $request->teacher_id,
        ]);

        // Redirect back to the class list with a success message
        return redirect()->route('class.index')->with('success', 'Class added successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(ClassModel $classModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassModel $classModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'class_code' => 'nullable|string|max:255',
            'class_room' => 'nullable|string|max:255',
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
        ]);

        // Update the class in the database
        DB::table('class')->where('class_id', $id)->update([
            'name' => $request->name,
            'class_code' => $request->class_code,
            'class_room' => $request->class_room,
            'teacher_id' => $request->teacher_id,
        ]);

        // Redirect back with a success message
        return redirect()->route('class.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the class from the database
        DB::table('class')->where('class_id', $id)->delete();

        // Redirect back with a success message
        return redirect()->route('class.index')->with('success', 'Class deleted successfully.');
    }

}
