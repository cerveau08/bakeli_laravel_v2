<?php
namespace App\Http\Controllers\API;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
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
    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token' => $token
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
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

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        $coachUsers = User::where('status', 'coach')->where('coach_is_actif', 1)->get();
        if ($user && \Hash::check($request->password, $user->password)) // The passwords match...
        {
            $token = self::getToken($request->email, $request->password);
            $user->auth_token = $token;
            $user->save();

            if ($user->status == 'bakeliste' && $user->coach_id != '') {
                foreach ($coachUsers as $coach) {
                    if ($coach->id == $user->coach_user_id) {
                        $user->coachFullname = $coach->first_name . ' ' . $coach->last_name;
                        $user->coachEmail = $coach->email;
                        $user->coachPhone = $coach->phone;
                    }
                }

                $today = date('Y-m-d');
                $todayTimestamp = strtotime($today);
                $endTrainingTimestamp = strtotime($user->fin_formation);

                if($todayTimestamp > $endTrainingTimestamp){
                    $user->trainingIsCompleted = 1;
                }else{
                    $user->trainingIsCompleted = 0;
                }
            }

            $response = [
                'success' => true,
                'data' => $user,
                'data2' => 'sadio'
            ];
            return response()->json($response, 201);
        } else{
            $response = [
                'success' => false,
                'data' => 'Record doesnt exists'
            ];
            return response()->json($response, 400);
        }
    }





    public function doLogout()
    {
        Auth::logout();
        $response = [
            'success' => true,
            'message' => 'Successfull logout user'
        ];


        return response()->json($response, 201);
    }

public function exportdata(){
    $allusers = User::all();
    foreach($allusers as $user){
        switch ($user->status){
            case bakeliste :
            $newuser = new user();
        break;
        case admin:
            $admins = new admin();
        break;
        case coach:
            $newcoach = new coach();
        break;
        case visiteur:
            $newvisisteur = new visteur();
        break;

        }

    }
}

}
