<?php

namespace App\Http\Controllers;

use Exception;
use App\User;
use Cache;
use Illuminate\Http\Request;

use App\Notifications\EmailConfirmNotification;
use Mail;

class EmailConfirmController extends Controller
{
    public function verify(Request $request) {
        $email = $request->input('email');
        $token = $request->input('token');

        if (!$email || !$token) {
            throw new Exception('��֤���Ӳ���ȷ');
        }

        // �ӻ����ж�ȡ���ݣ����ǰѴ� url �л�ȡ�� `token` �뻺���е�ֵ���Ա�
        // ������治���ڻ��߷��ص�ֵ�� url �е� `token` ��һ�¾��׳��쳣��
        if ($token != Cache::get('email_confirm_'.$email)) {
            throw new Exception('��֤���Ӳ���ȷ���ѹ���');
        }

        // ������������ݿ��л�ȡ��Ӧ���û�
        // ͨ����˵��ͨ�� token У�������²����ܳ����û�������
        // ����Ϊ�˴���Ľ�׳�����ǻ�����Ҫ������ж�
        if (!$user = User::where('email', $email)->first()) {
            throw new Exception('�û�������');
        }

        // ��ָ���� key �ӻ�����ɾ���������Ѿ��������֤����������û�б�Ҫ����������
        Cache::forget('email_confirm_'.$email);

        // ��ؼ��ģ�Ҫ�Ѷ�Ӧ�û��� `email_verified` �ֶθ�Ϊ `true`��
        $user->update(['email_verified' => true]);

        // ����֪�û�������֤�ɹ���
        return view('auth.email_confirm_success', ['msg' => '������֤�ɹ�']);
    }
//EmailConfirmController
    public function send(Request $request) {
        $user = $request->user();

        if ($user->email_verified) {
            throw new Exception('���Ѿ���֤��������');
        }

        // ���� notify() ���������������Ƕ���õ�֪ͨ��
        $user->notify(new EmailConfirmNotification());

        return view('auth.email_confirm_success', ['msg' => '�ʼ����ͳɹ�']);
    }

    public function notice(Request $request) {
        //return view('auth.email_confirm_notice');
        return view('auth.confirm');
    }
}
