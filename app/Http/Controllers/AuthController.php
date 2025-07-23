<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Set;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth\UserQuery;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Chargily\ChargilyPay\ChargilyPay;
use Kreait\Firebase\JWT\IdTokenVerifier;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use Illuminate\Support\Str;


class AuthController extends Controller
{
  //
  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'uid' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }


    $auth = Firebase::auth();

    try {
      //$firebase_user = $auth->getUser($request->uid);

      //$firebase_token = $auth->verifyIdToken($request->firebase_token);

      //$uid = $firebase_token->claims()->get('sub');

      $firebase_user = $auth->getUser($request->uid);
      $user = User::create([
        'name' => $firebase_user->displayName,
        'email' => $firebase_user->email,
        'phone' => $firebase_user->phoneNumber,
        'image' => $firebase_user->photoUrl,
        'password'=>$firebase_user->passwordHash,
      ]);

      $token = $user->createToken(Str::random(60))->plainTextToken;

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'token' => $token,
        'data' => new UserResource($user),
      ]);
    } catch (Exception $e) {
      //dd($e->getMessage());

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function login(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'uid' => 'required',
      'fcm_token' => 'sometimes',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    $auth = Firebase::auth();

    try {

      $firebase_user = $auth->getUser($request->uid);

      $user = User::firstOrCreate(
        ['email' => $firebase_user->email],
        [
          'name' => $firebase_user->displayName ?? 'user#' . uuid_create(),
          'phone' => $firebase_user->phoneNumber,
          'image' => $firebase_user->photoUrl,
        ]
      )->refresh();


      if ($request->has('fcm_token')) {
        $user->fcm_token = $request->fcm_token;
        $user->save();
      }

$token = $user->createToken(Str::random(60))->plainTextToken;

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'token' => $token,
        'data' => new UserResource($user),
      ]);
    } catch (Exception $e) {
      //dd($e->getMessage());

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function logout(Request $request)
  {
    try {

      $request->user()->currentAccessToken()->delete();

      return response()->json([
        'status' => 1,
        'message' => 'logged out',
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }
}
