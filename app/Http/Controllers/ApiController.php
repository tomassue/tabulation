<?php

namespace App\Http\Controllers;

use App\Models\Higalaay;
use App\Models\HigalaayDeduction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }
    public function saveData(Request $request)
    {
        $countData = 0;
        $data = '';
        $countDeductions = 0;
        if (isset($request->higalaay)) {
            $higalaay = $request->higalaay;
            foreach ($higalaay as  $value) {

                $countData += Higalaay::updateOrCreate(
                    [
                        'participant_id' => $value['participant_id'],
                        'criteria_id' => $value['criteria_id'],
                        'judge_id' => $value['judge_id'],
                        'category' => $value['category'],
                    ],
                    $value
                )->wasChanged() ? 1 : 0;
                $data .=  '<br/><b>[ changed: ' . $countData . ' participant_id:' . $value['participant_id'] . ', criteria_id: ' . $value['criteria_id'] . ', judge_id:' . $value['judge_id'] . ',category: ' . $value['category'] . ', score:' . $value['score'] . ']<b>';
            }
        }
        if (isset($request->deductions)) {
            $deductions = $request->deductions;
            foreach ($deductions as $value) {
                $countDeductions += HigalaayDeduction::updateOrCreate(
                    [
                        'participant_id' => $value['participant_id'],
                    ],
                    $value
                )->wasChanged() ? 1 : 0;
            }
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'activity' =>  '(API Update) Event Data Affected: ' . $countData . ', Deductions Affected: ' . $countDeductions . ' | ' . $data,
        ]);
        return response()->json([
            'message' => 'Data Affected: ' . $countData . ', Deductions Affected: ' . $countDeductions,
        ]);
    }
    public function getReference()
    {
        $criteria = DB::table('ref_criterias')->get();
        $judges = DB::table('ref_judges')->get();
        $participants = DB::table('ref_participants')->get();
        $deductions = DB::table('ref_deductions')->get();
        $categories = DB::table('categories')->get();
        $users = DB::table('users')->where('role', '<>', 'admin')->get();
        return response()->json([
            "criteria" => $criteria,
            "judges" => $judges,
            "participants" => $participants,
            "deductions" => $deductions,
            "categories" => $categories,
            "users" => $users
        ]);
    }
}
