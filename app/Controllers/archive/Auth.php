<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    
    public function forgot_password()
    {
        $email = session()->get('user_email');

        if (!$email) {
            return redirect()->to('/')->with('error', 'Silakan login dulu.');
        }

        $maskedEmail = $this->maskEmail($email);
        session()->setFlashdata('masked_email', $maskedEmail);

        // Simpan token reset password
        $token = bin2hex(random_bytes(16));
        $model = new UserModel();
        $model->where('email', $email)->set(['reset_token' => $token])->update();

        // (opsional) Kirim email berisi link reset password: /auth/reset-password/{token}

        return view('auth/forgot_confirmation');
    }

    public function resetPassword($token)
    {
        $model = new UserModel();
        $user = $model->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('/')->with('error', 'Token tidak valid.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('/')->with('error', 'Token tidak valid.');
        }

        $model->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
        ]);

        return redirect()->to('/')->with('success', 'Password berhasil direset.');
    }

    private function maskEmail($email)
    {
        $atPos = strpos($email, '@');
        if ($atPos !== false) {
            $name = substr($email, 0, 1);
            $domain = substr($email, $atPos);
            return $name . str_repeat('*', 6) . $domain;
        }
        return $email;
    }
}
