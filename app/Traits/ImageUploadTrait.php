<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function save($data)
    {
        // Delete old image
        if (isset($data['old_image']) && !empty($data['old_image'])) {
            Storage::delete($data['old_image']);
        }
        $imageName = uniqid() . '.' . $data['image']->extension();
        $data['image']->storeAs($data['path'], $imageName);
        return $data['save_path'] . '/' . $imageName;
    }
    public function uploadFile($data)
    {
        // Delete old image
        if (isset($data['old_image']) && !empty($data['old_image'])) {
            Storage::delete($data['old_image']);
        }
        $imageName = uniqid() . '.' . $data['image']->extension();
        $data['image']->storeAs($data['path'], $imageName);
        return $data['save_path'] . '/' . $imageName;
    }

    public function uploda($path, $save_path, $image)
    {
        $imageName = uniqid() . '.' . $image->extension();
        $image->storeAs($path, $imageName);
        return $save_path . '/' . $imageName;
    }

    public function base64($data)
    {
        // Delete old image
        if (isset($data['old_image']) && !empty($data['old_image'])) {
            Storage::disk('public')->delete($data['old_image']);
        }

        // Match ANY mime type (image/pdf/etc)
        preg_match('/^data:(.*?);base64,/', $data['image'], $matches);

        if (!$matches) {
            throw new \Exception('Invalid base64 format');
        }

        $mime = $matches[1]; // e.g. image/png OR application/pdf

        // Get extension from mime
        $mimeParts = explode('/', $mime);
        $extension = end($mimeParts);

        // Fix for common cases
        if ($extension == 'jpeg') $extension = 'jpg';
        if ($extension == 'pdf') $extension = 'pdf';

        // Decode base64
        $file = substr($data['image'], strpos($data['image'], ',') + 1);
        $file = base64_decode($file);

        if ($file === false) {
            throw new \Exception('Base64 decode failed');
        }

        // Optional: validate allowed types
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
        if (!in_array($extension, $allowed)) {
            throw new \Exception('File type not allowed');
        }

        $fileName = uniqid() . '.' . $extension;

        Storage::put($data['path'] . '/' . $fileName, $file);

        return $data['save_path'] . '/' . $fileName;
    }
}
