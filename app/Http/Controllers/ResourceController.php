<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = Resource::where('is_active', true)->latest();

        if ($category) {
            $query->where('category', $category);
        }

        $resources = $query->paginate(12)->withQueryString();
        $categories = Resource::where('is_active', true)->distinct()->pluck('category');

        return view('resources.index', compact('resources', 'categories', 'category'));
    }

    public function show(int $id): View
    {
        $resource = Resource::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return view('resources.show', compact('resource'));
    }

    public function download(int $id)
    {
        $resource = Resource::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $resource->increment('download_count');

        if ($resource->file_path) {
            $publicFile = public_path($resource->file_path);
            if (file_exists($publicFile)) {
                return response()->download(
                    $publicFile,
                    \Illuminate\Support\Str::slug($resource->title) . '.' . ($resource->file_type ?? 'pdf')
                );
            }
            $storageFile = storage_path('app/public/' . $resource->file_path);
            if (file_exists($storageFile)) {
                return response()->download(
                    $storageFile,
                    \Illuminate\Support\Str::slug($resource->title) . '.' . ($resource->file_type ?? 'pdf')
                );
            }
        }

        // Generate official hospital document response
        $filename = \Illuminate\Support\Str::slug($resource->title) . '.txt';
        $content = "APEX HEALTH REGIONAL HOSPITAL\n";
        $content .= "OFFICIAL INSTITUTIONAL PUBLICATION\n";
        $content .= "========================================================\n\n";
        $content .= "Title: " . $resource->title . "\n";
        $content .= "Category: " . $resource->category . "\n";
        $content .= "Document Format: " . ($resource->file_type ?? 'PDF') . "\n";
        $content .= "File Size: " . ($resource->file_size ?? '1.5 MB') . "\n";
        $content .= "Published: " . $resource->created_at->format('M d, Y') . "\n";
        $content .= "Download Verification ID: EPH-DOC-" . str_pad((string)$resource->id, 5, '0', STR_PAD_LEFT) . "\n\n";
        $content .= "OFFICIAL CLINICAL & INSTITUTIONAL SUMMARY:\n";
        $content .= "--------------------------------------------------------\n";
        $content .= $resource->description . "\n\n";
        $content .= "IMPORTANT NOTICE:\n";
        $content .= "This is an official hospital institutional publication provided for patient guidance,\n";
        $content .= "clinical referral, and procedural transparency. For questions or verification,\n";
        $content .= "please contact Ephamarcy Hospital Quality & Standards Desk at info@ephamarcyhosp.com.\n\n";
        $content .= "Ephamarcy Hospital — Clinical Excellence & Compassionate Care.\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}

