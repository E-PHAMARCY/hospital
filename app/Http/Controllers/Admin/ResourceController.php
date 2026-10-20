<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = Resource::latest();

        if ($category) {
            $query->where('category', $category);
        }

        $resources = $query->paginate(15)->withQueryString();
        $categories = Resource::distinct()->pluck('category');

        return view('admin.resources.index', compact('resources', 'categories', 'category'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'description_en' => ['required', 'string', 'max:1000'],
            'description_sw' => ['nullable', 'string', 'max:1000'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:15360'],
            'external_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['description_sw'])) {
            $validated['description_sw'] = $validated['description_en'];
        }

        if ($request->hasFile('document_file')) {
            $dest = public_path('uploads/resources');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('document_file');
            $ext = strtoupper($file->getClientOriginalExtension());
            $sizeBytes = $file->getSize();
            $formattedSize = $this->formatBytes($sizeBytes);
            
            $filename = 'doc_' . time() . '_' . uniqid() . '.' . strtolower($ext);
            $file->move($dest, $filename);

            $validated['file_path'] = 'uploads/resources/' . $filename;
            $validated['file_type'] = $ext;
            $validated['file_size'] = $formattedSize;
        } else {
            $validated['file_type'] = 'PDF';
            $validated['file_size'] = '1.5 MB';
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['download_count'] = 0;

        Resource::create($validated);

        return back()->with('success', "Patient publication '{$validated['title_en']}' published successfully.");
    }

    public function update(Request $request, Resource $resource): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'description_en' => ['required', 'string', 'max:1000'],
            'description_sw' => ['nullable', 'string', 'max:1000'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:15360'],
            'external_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['description_sw'])) {
            $validated['description_sw'] = $validated['description_en'];
        }

        if ($request->hasFile('document_file')) {
            $dest = public_path('uploads/resources');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('document_file');
            $ext = strtoupper($file->getClientOriginalExtension());
            $sizeBytes = $file->getSize();
            $formattedSize = $this->formatBytes($sizeBytes);
            
            $filename = 'doc_' . time() . '_' . uniqid() . '.' . strtolower($ext);
            $file->move($dest, $filename);

            $validated['file_path'] = 'uploads/resources/' . $filename;
            $validated['file_type'] = $ext;
            $validated['file_size'] = $formattedSize;
        }

        $validated['is_active'] = $request->boolean('is_active', $resource->is_active);

        $resource->update($validated);

        return back()->with('success', "Resource '{$resource->title_en}' updated successfully.");
    }

    public function toggleStatus(Resource $resource): RedirectResponse
    {
        $resource->update(['is_active' => !$resource->is_active]);
        $statusText = $resource->is_active ? 'published' : 'unpublished';

        return back()->with('success', "Resource '{$resource->title}' is now {$statusText}.");
    }

    public function destroy(Resource $resource): RedirectResponse
    {
        $title = $resource->title;
        $resource->delete();

        return back()->with('success', "Resource '{$title}' removed.");
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }
}
