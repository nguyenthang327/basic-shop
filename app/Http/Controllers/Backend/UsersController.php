<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    //
    public function index(Request $request) {

        $sort = $request->query('sort', "");
        $searchKeyword = $request->query('name', "");

        $queryORM = User::where('name', "LIKE", "%".$searchKeyword."%")
                        ->where('is_admin',0);

        if ($sort == "name_asc") {
            $queryORM->orderBy('name', 'asc');
        }
        if ($sort == "name_desc") {
            $queryORM->orderBy('name', 'desc');
        }

        $users = $queryORM->paginate(10);

        // truyền dữ liệu xuống view
        $data = [];
        $data["users"] = $users;

        // truyền keyword search xuống view
        $data["searchKeyword"] = $searchKeyword;
        $data["sort"] = $sort;

        return view("backend.users.index", $data);
    }

    public function delete($id) {
        $user = User::findOrFail($id);

        // truyền dữ liệu xuống view
        $data = [];
        $data["user"] = $user;

        return view("backend.users.delete", $data);
    }

    public function destroy($id) {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect("/backend/users/index")->with('status', 'xóa user thành công !');
    }
}
