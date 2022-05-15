<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WebsiteResource;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function index()
    {
        return response(['websites' => WebsiteResource::collection(Website::all())]);
    }

    public function subscribe(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'website_id' => 'required|exists:websites,id',
            'user_name' => 'required|max:255',
            'user_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user = $this->isUserAlreadyExists($request->all());
        $user->websites()->sync([$request->website_id]);

        return response(['message' => 'User is successfully subscribed to the website!']);
    }

    private function isUserAlreadyExists($data)
    {
        $user = User::where('email', $data['user_email'])->first();
        if (!$user) {
            $user = User::create([
                'name' => $data['user_name'],
                'email' => $data['user_email']
            ]);
        }
        return $user;
    }
}
