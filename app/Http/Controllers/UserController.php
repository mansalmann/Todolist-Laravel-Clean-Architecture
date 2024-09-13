<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService){
    }
    // menampilkan halaman login
    public function loginPage():Response{
        return response()->view("user.login", [
            "title" => "Halaman Login"
        ]);
    }

    // aksi dari login
    public function userLogin(LoginRequest $request):Response | RedirectResponse{

        // validasi data
        $data = $request->validated();
        $email = $data["user"];
        $password = $data["password"];

        // jika login sukses
        if($this->userService->login($email,$password)){
            // buat session email
            $request->session()->put("user",$email);
            return redirect(to: "/");
        }else{
            // jika login gagal
            return response()->view("user.login",[
                "title" => "Halaman Login",
                "error" => "Username atau password salah"
            ]);
        }
    }

    // aksi untuk logout
    public function userLogout(Request $request):RedirectResponse{
        // hapus data session user
        $request->session()->forget("user");
        return redirect("/");
    }
}
