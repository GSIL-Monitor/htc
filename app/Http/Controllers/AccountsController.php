<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Models\Camera;
use App\Models\Email;

class AccountsController extends Controller
{
    public function back_to_login($portal) {
        //if (!Auth::check()) {
            //session()->flash('warning', 'Please Login first');
            //return redirect()->route('login');
            if ($portal == 10) {
                return redirect()->route('login.10ware');
            } else if ($portal == 11) {
                return redirect()->route('login.germany');
            } else {
                return redirect()->route('login');
            }
        //}
    }

    /*-----------------------------------------------------------*/
    public function activetab(Request $request) {
        $portal = $_POST['portal'];
        if (!Auth::check()) {
            return $this->back_to_login($portal);
        }

        // plan, billing, devices, options, email
        // plans, billing, remote, security, email
        $sel_account_tab = $_POST['tab'];
        $data['sel_account_tab'] = $sel_account_tab;
        Auth::user()->update($data);
        return $sel_account_tab;
    }

    /*-----------------------------------------------------------*/
    public function _profile($portal) {
        if (!Auth::check()) {
            return $this->back_to_login($portal);
        }

        $user = Auth::user();
        $data['sel_menu'] = 'account';
        $user->update($data);

        //return view('account.profile', compact('user'));
        return view('account.profile', compact('portal', 'user'));
    }

    public function profile() {
        return $this->_profile(0);
    }

    public function profile_10ware() {
        return $this->_profile(10);
    }

    /*-----------------------------------------------------------*/
    public function MyPlans() {
        //return 'Hello';
        $user = Auth::user();
        $user_id = $user->id;

        $plans = DB::table('plans')
            ->where('user_id', $user_id)
            ->get();

        $handle = '';
        foreach ($plans as $plan) {
            $camera_name = '(No Camera)';
            if ($plan->camera_id) {
                $camera = Camera::find($plan->camera_id);
                if ($camera) {
                    $camera_name = $camera->description;
                }
            }

            $handle .= '<div class="row">';
            $handle .=     '<div class="col-md-12">';
            $handle .=         '<div style="margin-top:10px; margin-bottom:4px; border-bottom: 1px solid gray;border-top: 1px solid lime; padding-bottom: 4px; padding-top: 4px;padding-left:10px; background-color: #444">';
            $handle .=             '<div class="row">';
            $handle .=                 '<div class="col-md-5">';
            $handle .=                     '<i class="fa fa-dot-circle"></i>';
            $handle .=                     '<span class="label label-info" style="font-size: 1.00em;">Prepaid 6 Months</span>';
            $handle .=                     '<span class="label label-success" style="font-size:0.9em;">Active</span>';
            $handle .=                     '<p></p>';
            $handle .=                 '</div>';
            $handle .=                 '<div class="col-md-5">';
            $handle .=                 '</div>'; // <!-- end col -->
            $handle .=             '</div>';
            $handle .=         '</div>';
            $handle .=     '</div>';
            $handle .= '</div>';

            $handle .= '<div class="row">';
            $handle .=     '<div class="col-sm-6">';
            $handle .=         '<table class="table plan-table">';
            $handle .=             '<tbody>';
//            $handle .=                 '<tr><td class="pull-right"><i class="fa fa-bolt"></i>Sim ICCID:</td>';
            $handle .=                 '<tr><td class="pull-right"></i>ICCID:</td>';
            $handle .=                     '<td><strong>'.$plan->iccid.'</strong></td>';
            $handle .=                 '</tr>';
//            //$handle .=                 '<tr><td class="pull-right"><i class="fa fa-camera"> </i> Camera:</td>';
//            $handle .=                 '<tr><td class="pull-right">Camera:</td>';
//            $handle .=                     '<td><strong>'.$camera_name.'</strong></td>';
//            $handle .=                 '</tr>';
            $handle .=                 '<tr><td class="pull-right">Plan Points:</td>';
            $handle .=                     '<td><strong>'.$plan->points.'</strong></td>';
            $handle .=                 '</tr>';
            $handle .=                 '<tr><td class="pull-right">Points Used:</td>';
            $handle .=                     '<td><strong>'.$plan->points_used.'</strong></td>';
            $handle .=                 '</tr>';
//            $handle .=                 '<tr><td class="pull-right">SMS Sent:</td>';
//            $handle .=                     '<td><strong>'.$plan->sms_sent.'</strong></td>';
//            $handle .=                 '</tr>';
            $handle .=             '</tbody>';
            $handle .=         '</table>';
            $handle .=     '</div>';
            $handle .= '</div>';
        }
        return $handle;
    }

    /*-----------------------------------------------------------*/
    public function Emails() {
        $user = Auth::user();
        $user_id = $user->id;

        $emails = DB::table('emails')->where('user_id', $user_id)->get();

        $email_addr = [];
        $index = 1;
        foreach ($emails as $email) {
            $email_addr[$index] = $email->email;
            $index++;
        }
//return count($email_addr);
//return $email_addr[1];

//return $emails;
//return $email->email;
//return count($emails);
//return $emails[0];

//$ret['emails'] = $emails;
//return $ret;

        $index = 1;
        $handle = '';
        $handle .= '<div class="col-md-6">';
        for ($i=1; $i<=2; $i++) {
            for ($j=1; $j<=5; $j++) {
                if (isset($email_addr[$index])) {
                    $value = $email_addr[$index];
                } else {
                    $value='';
                }

                //$id = 'g'.$i.'_email'.$j;
                $id = 'email_'.$index;
                $placeholder = 'Input Email '.$index;
                $handle .= '<div class="row">';
                $handle .=     '<div class="col-md-12">';
                ////$handle .=         <!--
                ////$handle .=         <div class="form-group">
                ////$handle .=             <label class="col-md-4 control-label">Email 1</label>
                ////$handle .=             <div class="col-md-7">
                ////$handle .=                 <input type="text" name="g1_email1" maxlength="70" value="test@gmail.com" id="g1_email1" class="form-control" placeholder="Input Email 1">
                ////$handle .=             </div>
                ////$handle .=         </div>
                ////$handle .=         -->
                $handle .=         '<div class="input-group" style="margin-bottom:8px;">';
                $handle .=             '<input type="text" name="'.$id.'" maxlength="70" value="'.$value.'" id="'.$id.'" class="form-control" placeholder="'.$placeholder.'">';
                $handle .=             '<div class="input-group-btn">';
                $handle .=                 '<button class="trash-email btn btn-default" style="background-color: #aaa;padding-top:12px!important;padding-bottom:12px!important;border: none;" input-id="'.$id.'" title="Clear Email">';
                $handle .=                     '<i class="glyphicon glyphicon-trash"></i>';
                $handle .=                 '</button>';
                $handle .=             '</div>';
                $handle .=         '</div>';
                $handle .=     '</div>';
                $handle .= '</div>';
                $index++;
            }
        }
        $handle .= '</div>';

        $handle .= '<div class="col-md-6">';
        for ($i=3; $i<=3; $i++) {
            for ($j=1; $j<=5; $j++) {
                //$id = 'g'.$i.'_email'.$j;
                $id = 'email_'.$index;
                $placeholder = 'Input Email '.$index;
                $handle .= '<div class="row">';
                $handle .=     '<div class="col-md-12">';
                $handle .=         '<div class="input-group" style="margin-bottom:8px;">';
                $handle .=             '<input type="text" name="'.$id.'" maxlength="70" value="" id="'.$id.'" class="form-control" placeholder="'.$placeholder.'">';
                $handle .=             '<div class="input-group-btn">';
                $handle .=                 '<button class="trash-email btn btn-default" style="background-color: #aaa;padding-top:12px!important;padding-bottom:12px!important;border: none;" input-id="'.$id.'" title="Clear Email">';
                $handle .=                     '<i class="glyphicon glyphicon-trash"></i>';
                $handle .=                 '</button>';
                $handle .=             '</div>';
                $handle .=         '</div>';
                $handle .=     '</div>';
                $handle .= '</div>';
                $index++;
            }
        }
        $handle .= '</div>';

        return $handle;
    }

    public function emails_save(Request $request) {
        $portal = $request->portal;
        if (!Auth::check()) {
            return $this->back_to_login($portal);
        }

        $user = Auth::user();
        $user_id = $user->id;

        $email_addr = [];
        for ($i=1; $i<=15; $i++) {
            $id = 'email_'.$i;
            if ($request[$id]) {
                array_push($email_addr, $request[$id]);
            }
        }
        $email_addr = array_unique($email_addr);
        $email_addr = array_reverse($email_addr);

        $affected = DB::update(
            'delete from emails where user_id = ?', [$user_id]
        );

        $count = count($email_addr);
        while ($count > 0) {
            $email = new Email;
            $email->email = array_pop($email_addr);
            $email->user_id = $user_id;
            $email->save();
            $count--;
        }

        //session()->flash('success', 'Success: Account Emails Saved. Some new email recipients were sent system email verifications. Until verified these addresses will not get any email.');
        session()->flash('success', 'Success: Account Emails Saved.');
        return redirect()->back();
    }

    //public function profile_emails() { // TODO
    //    if (!Auth::check()) {
    //        session()->flash('warning', 'Please Login first');
    //        return redirect()->route('login');
    //    }
    //
    //    $user = Auth::user();
    //    //$user_id = $user->id;
    //    return view('account.profile', compact('user'));
    //}

    /*-----------------------------------------------------------*/
    // 4242 4242 4242 4242
    public function billing(Request $request) {
        return $request;
    }
}
