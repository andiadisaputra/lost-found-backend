<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ApiResponse;

    public function show(Request $request)
    {
        return $this->success(
            'Data profil.',
            new UserResource($request->user())
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($data);

        return $this->success(
            'Profil berhasil diperbarui.',
            new UserResource($user->fresh())
        );
    }
}
