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
        $higalaayInsertedData = 0;
        $higalaayUpdatedData = 0;
        $higalaayInsertedDeductionData = 0;
        $higalaayUpdatedDeductionData = 0;
        $data = '';
        if (isset($request->higalaay)) {
            $higalaay = $request->higalaay;
            foreach ($higalaay as  $value) {

                $hig = Higalaay::updateOrCreate(
                    [
                        'participant_id' => $value['participant_id'],
                        'criteria_id' => $value['criteria_id'],
                        'judge_id' => $value['judge_id'],
                        'category' => $value['category'],
                    ],
                    $value
                );
                $details = $value['participant_id'] . ', criteria_id: ' . $value['criteria_id'] . ', judge_id:' . $value['judge_id'] . ',category: ' . $value['category'] . ', score:' . $value['score'];
                if ($hig->wasRecentlyCreated) {
                    $higalaayInsertedData += 1;
                    $data .=  '<br/><b>[ Inserted: participant_id:' . $details . ']<b>';
                } else {
                    if ($hig->wasChanged()) {
                        $higalaayUpdatedData += 1;
                        $data .=  '<br/><b>[ Updated: participant_id:' . $details . ']<b>';
                    }
                }
            }
        }
        if (isset($request->deductions)) {
            $deductions = $request->deductions;
            foreach ($deductions as $value) {
                $deduct = HigalaayDeduction::updateOrCreate(
                    [
                        'participant_id' => $value['participant_id'],
                        'category' => $value['category'],
                    ],
                    $value
                );
                if ($deduct->wasRecentlyCreated) {
                    $higalaayInsertedDeductionData += 1;
                    $data .=  '<br/><b>[Deduction Inserted: participant_id:' . $value['participant_id'] . ', category: ' . $value['category'] . ']<b>';
                } else {
                    if ($deduct->wasChanged()) {
                        $higalaayUpdatedDeductionData += 1;
                        $data .=  '<br/><b>[Deduction Updated: participant_id:' . $value['participant_id'] . ', category: ' . $value['category'] . ']<b>';
                    }
                }
            }
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'activity' =>  '(API Update) Event Data Affected: ' . $higalaayInsertedData + $higalaayUpdatedData . ', Deductions Affected: ' . $higalaayInsertedDeductionData + $higalaayUpdatedDeductionData . ' | ' . $data,
        ]);
        return response()->json([
            'message' => 'Data Affected: Inserted(' . $higalaayInsertedData . '), Updated(' . $higalaayUpdatedData . '), Inserted Deductions(' . $higalaayInsertedDeductionData . '), Updated Deductions(' . $higalaayUpdatedDeductionData . ')',
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
    public function downloadDatabase()
    {
        $higalaays = Higalaay::get();
        $higalaay_deductions = HigalaayDeduction::get();

        return response()->json([
            "higalaays" => $higalaays,
            "higalaay_deductions" => $higalaay_deductions,
        ]);
    }
}
