<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Handle image upload as a method to reuse
    private function handleImageUpload($image)
    {
        if ($image) {
            $path = $image->storeAs('public/news', $image->hashName());
            return $image->hashName();
        }
        return null;
    }
    
    // handle image deletion
    private function deleteOldImage($imageName)
    {
        if ($imageName && Storage::disk('public')->exists('news/' . $imageName)) {
            Storage::disk('public')->delete('news/' . $imageName);
        }
    }

    public function index()
    {
        $news = News::select('news.id', 'news.news_title', 'news.news_content', 'news.news_image', 'news.news_category', 'edtions.title as editon_title', 'news.submission_status', 'news.notes', 'news.created_at', 'news.updated_at')
                    ->join('edtions', 'news.news_edition', '=', 'edtions.id')
                    ->get();
        return new PostResource(true, 'News fetched successfully', $news);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'news_title' => 'required|string|max:255',
            'news_content' => 'required|string',
            'news_image' => 'required|image|max:2048',
            'news_category' => 'required|string|max:255',
            'news_edition' => 'required|integer',
            'submission_status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imageName = $this->handleImageUpload($request->file('news_image'));

        $news = News::create([
            'news_title' => $request->news_title,
            'news_content' => $request->news_content,
            'news_image' => $imageName,
            'news_category' => $request->news_category,
            'news_edition' => $request->news_edition,
            'submission_status' => $request->submission_status,
            'notes' => $request->notes,
        ]);

        return new PostResource(true, 'News created successfully', $news);
    }

    public function show ($id)
    {
        $news = News::select('news.id', 'news.news_title', 'news.news_content', 'news.news_image', 'news.news_category', 'edtions.title as editon_title', 'news.submission_status', 'news.notes', 'news.created_at', 'news.updated_at')
                    ->join('edtions', 'news.news_edition', '=', 'edtions.id')
                    ->where('news.id', $id)
                    ->first();
        if ($news) {
            return new PostResource(true, 'News fetched successfully', $news);
        }
        return new PostResource(false, 'News not found', null);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if ($news) {
            $validator = Validator::make($request->all(), 
            [
                'news_title' => 'required|string|max:255',
                'news_content' => 'required|string',
                'news_image' => 'nullable|image|max:2048',
                'news_category' => 'required|string|max:255',
                'news_edition' => 'required|integer',
                'submission_status' => 'required|string|max:255',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Hapus file gambar lama jika ada
            if ($request->hasFile('news_image')) {
                $this->deleteOldImage($news->news_image); // Panggil fungsi untuk menghapus gambar lama
                $imageName = $this->handleImageUpload($request->file('news_image'));
                $news->news_image = $imageName;
            }

            $news->news_title = $request->news_title;
            $news->news_content = $request->news_content;
            $news->news_image = $imageName;
            $news->news_category = $request->news_category;
            $news->news_edition = $request->news_edition;
            $news->submission_status = $request->submission_status;
            $news->notes = $request->notes;
            $news->save();

            return new PostResource(true, 'News updated successfully', $news);
        }
        return new PostResource(false, 'News not found', null);
    }

    public function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            $this->deleteOldImage($news->news_image); // Panggil fungsi untuk menghapus gambar lama
            $news->delete();
            return new PostResource(true, 'News deleted successfully', null);
        }
        return new PostResource(false, 'News not found', null);
    }
}
