<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\AppBaseController;


class UserAPIController extends AppBaseController
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontendUserLogin(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        $userInfos = User::where('email', $request->email)->first();

        return response()->json([
            'success' => true,
            'token' => $token,
            'user_data' => $userInfos
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function frontendUserLogout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * Handles for
     */

    /**
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontendUserRegister(Request $request)
    {
        $user = new User();
        $user->user_fullname = $request->user_fullname;
        $user->email = $request->email;
        $user->status = 'frontend-user';
        $user->password = bcrypt($request->password);
        $user->save();

        // if ($this->loginAfterSignUp) {
        //     return $this->login($request);
        // }

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ], 200);
    }

    public function importUser(Request $request)
    {
        $users = DB::connection('mysql2')->select('SELECT * FROM `bsi_api_users`', [1]);
        // dd($users);
        foreach ($users as $usera) {
            //dd($usera->first_name.' '.$usera->last_name);
            //dd($usera);
            $user = new Users();
            $user->id = $usera->id;
            $user->user_fullname = $usera->first_name.' '.$usera->last_name;
            $user->email = $usera->email;
            $user->password = bcrypt($usera->password);
            $user->status = 'frontend-user';
            $user->save();
        }
        return response()->json([
        'success' => true,
        'data' => $user
        ], 200);
    }
}